<?php
	require('init.php');

	if (!isAdmin())
		render('403');

	if (getVar('add'))
	{
		$addLicenceQuery = $dbh->prepare('INSERT INTO licences (name) VALUES (:name)');
		$addLicenceQuery->execute(array(':name' => getVar('add')));
	}
	if (getVar('delete'))
	{
		$deleteLicenceQuery = $dbh->prepare('DELETE FROM licences WHERE id = :id');
		$deleteLicenceQuery->execute(array(':id' => getVar('delete')));
	}

	$licencesQuery = $dbh->prepare('SELECT id, name FROM licences ORDER BY id');
	$licencesQuery->execute();
	$licences = $licencesQuery->fetchAll();
	$licencesQuery->closeCursor();

	render('admin-licences', array('licences' => $licences));
?>