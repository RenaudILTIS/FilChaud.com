<?php
	require('init.php');

	if (!isLogged())
		render('403');

	if (getVar('newObject'))
	{
		//debug($_POST);
		$addObjectQuery = $dbh->prepare('INSERT INTO objects (name, category_id, licence_id, raw_material, hot_wire_id, description, user_id) VALUES (:name, :category_id, :licence_id, :raw_material, :hot_wire_id, :description, :user_id)');
		$addObjectQuery->execute(array(':name' => getVar('name'), ':category_id' => (int)getVar('category'), ':licence_id' => (int)getVar('licence'), ':raw_material' => getVar('raw_material'), ':hot_wire_id' => (int)getVar('hotwire'), ':description' => getVar('description'), ':user_id' => (int)$_SESSION['id']));

		$id = $dbh->lastInsertId();
		if (!empty($_POST['videos']))
		{
			$i = 0;
			foreach ($_POST['videos'] as $video)
			{
				$description = $_POST['descriptions'][$i++];
				$addVideoQuery = $dbh->prepare('INSERT INTO objects_videos (object_id, url, description) VALUES (:object_id, :url, :description)');
				$addVideoQuery->execute(array(':object_id' => $id, ':url' => $video, ':description' => $description));
			}
		}
		
		sendemail('contact@filchaud.com', EMAIL, 'Un nouveau projet sur FilChaud.com', 'Le projet '.':name'.'  a été mis en ligne sur FilChaud.com');
		die($id);
	}
	else if (getVar('newFile'))
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
			if(move_uploaded_file($_FILES['file']['tmp_name'], 'files/'.$id.'/'.basename($_FILES['file']['name'])))
				$files[] = 'files/'.$_FILES['file']['name'];
			else
				$error = 'Internal error';

			$addFileQuery = $dbh->prepare('INSERT INTO objects_files (object_id, name, description) VALUES (:object_id, :name, :description)');
			$addFileQuery->execute(array(':object_id' => $id, ':name' => $_FILES['file']['name'], ':description' => getVar('comment')));
		}

		$data = ($error) ? array('error' => $error) : array('files' => $files);

		die(json_encode($data));
	}
	else if (getVar('newPicture'))
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
			$filename = (getVar('i') == '0')? 'image.jpg' : basename($_FILES['file']['name']);
			if(move_uploaded_file($_FILES['file']['tmp_name'], 'files/'.$id.'/'.$filename))
				$files[] = 'files/'.$id.'/'.$filename;
			else
				$error = 'Internal error';

			$addFileQuery = $dbh->prepare('INSERT INTO objects_pictures (object_id, file, description) VALUES (:object_id, :file, :description)');
			$addFileQuery->execute(array(':object_id' => $id, ':file' => $filename, ':description' => getVar('comment')));
		}

		$data = ($error) ? array('error' => $error) : array('files' => $files);
		die(json_encode($data));
	}

	$categoriesQuery = $dbh->prepare('SELECT id, name FROM categories ORDER BY id');
	$categoriesQuery->execute();
	$categories = $categoriesQuery->fetchAll();
	$categoriesQuery->closeCursor();

	$licencesQuery = $dbh->prepare('SELECT id, name FROM licences ORDER BY id');
	$licencesQuery->execute();
	$licences = $licencesQuery->fetchAll();
	$licencesQuery->closeCursor();

	$hotwiresQuery = $dbh->prepare('SELECT id, name FROM wires ORDER BY id');
	$hotwiresQuery->execute();
	$hotwires = $hotwiresQuery->fetchAll();
	$hotwiresQuery->closeCursor();


	render('upload', array('categories' => $categories, 'licences' => $licences, 'wires' => $hotwires));
?>
