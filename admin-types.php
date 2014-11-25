<?php
	require('init.php');

	if (!isAdmin())
		render('403');

	if (getVar('add'))
	{
		$addMaterialQuery = $dbh->prepare('INSERT INTO file_types (name, extension, mimetype) VALUES (:name, :extension, :mimetype)');
		$addMaterialQuery->execute(array(':name' => getVar('add'), ':extension' => getVar('extension'), ':mimetype' => getVar('mimetype')));
	}
	if (getVar('delete'))
	{
		$deleteMaterialQuery = $dbh->prepare('DELETE FROM file_types WHERE id = :id');
		$deleteMaterialQuery->execute(array(':id' => getVar('delete')));
	}

	$typesQuery = $dbh->prepare('SELECT id, name, extension, mimetype FROM file_types ORDER BY id');
	$typesQuery->execute();
	$types = $typesQuery->fetchAll();
	$typesQuery->closeCursor();

	render('admin-types', array('types' => $types));
?>