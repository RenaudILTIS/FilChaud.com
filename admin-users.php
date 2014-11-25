<?php
	require('init.php');

	if (!isAdmin())
		render('403');

	if (getVar('delete'))
	{
		$deleteLicenceQuery = $dbh->prepare('DELETE FROM users WHERE id = :id');
		$deleteLicenceQuery->execute(array(':id' => getVar('delete')));
	}

	$licencesQuery = $dbh->prepare('SELECT id, login, email, is_admin FROM users ORDER BY id');
	$licencesQuery->execute();
	$licences = $licencesQuery->fetchAll();
	$licencesQuery->closeCursor();

	render('admin-users', array('users' => $licences));
?>