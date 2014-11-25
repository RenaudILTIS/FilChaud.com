<?php
	require('init.php');

	global $dbh;
	$userQuery = $dbh->prepare('SELECT id, login, is_admin FROM users WHERE login = :login AND password = :password');
	$userQuery->execute(array(':login' => getVar('username'), ':password' => passwordHash(getVar('password'))));
	$user = $userQuery->fetch();

	if (!$user['id'])
	    render('403');
	else
	{
	    $_SESSION['id'] = $user['id'];
	    $_SESSION['login'] = $user['login'];
	    if ($user['is_admin'])
	    	$_SESSION['key'] = ADMIN_KEY;
	}

	$objectsQuery = $dbh->prepare('SELECT id, name, description FROM objects ORDER BY id DESC');
	$objectsQuery->execute();
	$objects = $objectsQuery->fetchAll();
	$objectsQuery->closeCursor();

	render('index', array('objects' => $objects));
?>