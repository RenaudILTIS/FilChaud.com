<?php
	require('init.php');

	$checkQuery = $dbh->prepare('SELECT id FROM objects WHERE id = :id AND user_id = :user_id');
	$checkQuery->execute(array(':id' => (getVar('edit'))?getVar('edit'):getVar('delete'), ':user_id' => $_SESSION['id']));
	$check = $checkQuery->fetch();
	$checkQuery->closeCursor();
	if (!$check['id'] && !isAdmin())
		render('403');

	if (getVar('name'))
	{
		$updateObjectQuery = $dbh->prepare('UPDATE objects SET name = :name, description = :description, category_id = :category_id, licence_id = :licence_id, raw_material = :raw_material, hot_wire_id = :wire WHERE id = :id');
		$updateObjectQuery->execute(array(':name' => getVar('name'), ':description' => getVar('description'), ':id' => getVar('edit'), ':category_id' => getVar('category'), ':licence_id' => getVar('licence'), ':raw_material' => getVar('raw_material'), ':wire' => getVar('wire')));

		// Redirect to object page
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/object.php?id='.getVar('edit')) ;
	}
	if (getVar('delete'))
	{
		$deleteObjectQuery = $dbh->prepare('DELETE FROM objects WHERE id = :id');
		$deleteObjectQuery->execute(array(':id' => getVar('delete')));

		$objectsQuery = $dbh->prepare('SELECT id, name, description FROM objects WHERE user_id = :user_id ORDER BY id DESC');
		$objectsQuery->execute(array(':user_id' => $_SESSION['id']));
		$objects = $objectsQuery->fetchAll();
		$objectsQuery->closeCursor();
		render('objects', array('objects' => $objects));
	}
	if (getVar('newPicture'))
	{
		$id = (int)getVar('id');

		if (!is_dir('files/'.$id))
			mkdir('files/'.$id);

		$data = array();
		$error = false;
		$files = array();
		$types = array('image/jpeg', 'image/png');

		$fileInfo = new finfo(FILEINFO_MIME);
		$fileType = explode(';', $fileInfo->buffer(file_get_contents($_FILES['file']['tmp_name'])))[0];

		if (!in_array($fileType, $types))
			$error = 'Invalid file"';

		if (!$error)
		{
			// If there's no image.jpeg, that image will be it.
			$filename = (file_exists('files/'.$id.'/image.jpg'))? basename($_FILES['file']['name']) : 'image.jpg';

			// If the files already exists, it's an update, not an addition
			if ($filename != 'image.jpg')
				$noSqlAddition = file_exists('files/'.$id.'/'.basename($_FILES['file']['name']));

			if(move_uploaded_file($_FILES['file']['tmp_name'], 'files/'.$id.'/'.$filename))
				$fileName = $filename;
			else
				$error = 'Internal error';

			if (!$noSqlAddition)
			{
				$addFileQuery = $dbh->prepare('INSERT INTO objects_pictures (object_id, file, description) VALUES (:object_id, :file, :description)');
				$addFileQuery->execute(array(':object_id' => $id, ':file' => $filename, ':description' => getVar('comment')));
				$fileId = $dbh->lastInsertId();
			}
			else
				$fileId = -1;
		}

		$data = ($error) ? array('error' => $error) : array('file' => $fileName, 'fileid' => $fileId, 'comment' => getVar('comment'), 'objectid' => getVar('id'));

		die(json_encode($data));
	}
	if (getVar('newFile'))
	{
		$id = (int)getVar('id');

		if (!is_dir('files/'.$id))
			mkdir('files/'.$id);

		$data = array();
		$error = 'Invalid file type';
		$files = array();

		$typesQuery = $dbh->prepare('SELECT mimetype FROM file_types');
		$typesQuery->execute();
		$types = $typesQuery->fetchAll();
		$typesQuery->closeCursor();

		$fileInfo = new finfo(FILEINFO_MIME);
		$fileType = explode(';', $fileInfo->buffer(file_get_contents($_FILES['file']['tmp_name'])))[0];

		foreach($types as $type)
			if ($type['mimetype'] == $fileType)
				$error = false;

		if (!$error)
		{
			//If the files already exists, it's an update, not an addition
			$noSqlAddition = file_exists('files/'.$id.'/'.basename($_FILES['file']['name']));

			if(move_uploaded_file($_FILES['file']['tmp_name'], 'files/'.$id.'/'.basename($_FILES['file']['name'])))
				$fileName = $_FILES['file']['name'];
			else
				$error = 'Internal error';

			if (!$noSqlAddition)
			{
				$addFileQuery = $dbh->prepare('INSERT INTO objects_files (object_id, name, description) VALUES (:object_id, :name, :description)');
				$addFileQuery->execute(array(':object_id' => $id, ':name' => $_FILES['file']['name'], ':description' => getVar('comment')));
				$fileId = $dbh->lastInsertId();
			}
			else
				$fileId = -1;
		}

		$data = ($error) ? array('error' => $error) : array('fileName' => $fileName, 'fileId' => $fileId);

		die(json_encode($data));
	}
	if (getVar('newVideo'))
	{
		$addFileQuery = $dbh->prepare('INSERT INTO objects_videos (object_id, url, description) VALUES (:object_id, :url, :description)');
		$addFileQuery->execute(array(':object_id' => getVar('id'), ':url' => getVar('url'), ':description' => getVar('comment')));
		$data = array('url' => parse_yturl(getVar('url')), 'comment' => getVar('comment'), 'objectid' => getVar('id'));
		die(json_encode($data));
	}
	if (getVar('deleteFile'))
	{
		$deleteObjectQuery = $dbh->prepare('DELETE FROM objects_files WHERE id = :id');
		$deleteObjectQuery->execute(array(':id' => getVar('deleteFile')));
		die('ok');
	}
	if (getVar('deletevideo'))
	{
		$deleteVideoQuery = $dbh->prepare('DELETE FROM objects_videos WHERE id = :id');
		$deleteVideoQuery->execute(array(':id' => getVar('deletevideo')));
		die('ok');
	}
	if (getVar('deletepicture'))
	{
		// Get infos and delete the file
		$getPictureQuery = $dbh->prepare('SELECT object_id, file FROM objects_pictures WHERE id = :id');
		$getPictureQuery->execute(array(':id' => getVar('deletepicture')));
		$pictureInfos = $getPictureQuery->fetch();
		$getPictureQuery->closeCursor();
		unlink('files/'.$pictureInfos['object_id'].'/'.$pictureInfos['file']);

		// Delete the DB entry
		$deletePictureQuery = $dbh->prepare('DELETE FROM objects_pictures WHERE id = :id');
		$deletePictureQuery->execute(array(':id' => getVar('deletepicture')));
		die('ok');
	}

	// Object's informations
	$objectQuery = $dbh->prepare('SELECT id, name, description, category_id, licence_id, hot_wire_id, raw_material FROM objects WHERE id = :id');
	$objectQuery->execute(array(':id' => getVar('edit')));
	$object = $objectQuery->fetch();
	$objectQuery->closeCursor();

	$picturesQuery = $dbh->prepare('SELECT id, file, description FROM objects_pictures WHERE object_id = :id AND file != "image.jpg"');
	$picturesQuery->execute(array(':id' => getVar('edit')));
	$pictures = $picturesQuery->fetchAll();
	$picturesQuery->closeCursor();

	$videosQuery = $dbh->prepare('SELECT id, url, description FROM objects_videos WHERE object_id = :id');
	$videosQuery->execute(array(':id' => getVar('edit')));
	$videos = $videosQuery->fetchAll();
	$videosQuery->closeCursor();

	$filesQuery = $dbh->prepare('SELECT id, name FROM objects_files WHERE object_id = :id');
	$filesQuery->execute(array(':id' => getVar('edit')));
	$files = $filesQuery->fetchAll();
	$filesQuery->closeCursor();

	// Editable parameters
	$categoriesQuery = $dbh->prepare('SELECT id, name FROM categories ORDER BY id');
	$categoriesQuery->execute();
	$categories = $categoriesQuery->fetchAll();
	$categoriesQuery->closeCursor();

	$licencesQuery = $dbh->prepare('SELECT id, name FROM licences ORDER BY id');
	$licencesQuery->execute();
	$licences = $licencesQuery->fetchAll();
	$licencesQuery->closeCursor();

	$wiresQuery = $dbh->prepare('SELECT id, name FROM wires ORDER BY id');
	$wiresQuery->execute();
	$wires = $wiresQuery->fetchAll();
	$wiresQuery->closeCursor();

	render('editobject', array('object' => $object, 'files' => $files, 'pictures' => $pictures, 'videos' => $videos, 'categories' => $categories, 'licences' => $licences, 'wires' => $wires));
?>