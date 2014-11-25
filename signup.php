<?php
	require('init.php');
    //global $dbh;
	
	$error = NULL;
	if (getVar('username') && getVar('email') && filter_var(getVar('email'), FILTER_VALIDATE_EMAIL) && getVar('pass1') && (getVar('pass1') == getVar('pass2')))
	{
		$password = passwordHash(getVar('pass1'));
		$checkQuery = $dbh->prepare('SELECT count(login) AS count FROM users WHERE login = :username OR email = :email');
		$checkQuery->execute(array(':username' => getVar('username'), ':email' => getVar('email')));
		$check = $checkQuery->fetch();
		$checkQuery->closeCursor();
		if ($check['count'])
			$error = (getLang() == 'en')? 'Login/email already exists' : 'Le login ou l\'email existent deja';
		else
		{
			$signupQuery = $dbh->prepare('INSERT INTO users (login, email, password) VALUES (:username, :email, :password)');
			$signupQuery->execute(array(':username' => getVar('username'), ':email' => getVar('email'), ':password' => $password));
			
			$userQuery = $dbh->prepare('SELECT id, login, is_admin FROM users WHERE login = :login AND password = :password');
			$userQuery->execute(array(':login' => getVar('username'), ':password' =>  $password));
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
		}
	}
	else if (getVar('pass1') && (getVar('pass1') != getVar('pass2')))
		$error = (getLang() == 'en')? 'Passwords don\'t match' : 'Les passwords sont differents';
	else if (!filter_var(getVar('email'), FILTER_VALIDATE_EMAIL))
		$error = (getLang() == 'en')? 'Invalid email' : 'Email invalide';
	else
		$error = (getLang() == 'en')? 'All fields are required' : 'Tous les champs sont obligatoire';


	$objectsQuery = $dbh->prepare('SELECT id, name, description FROM objects ORDER BY id DESC LIMIT :start,:count');
	$objectsQuery->execute(array(':start' => (getVar('page'))?(int)getVar('page')*OBJECTS_PER_PAGE:0, ':count' => OBJECTS_PER_PAGE));
	$objects = $objectsQuery->fetchAll();
	$objectsQuery->closeCursor();

	render('index', array('objects' => $objects, 'pageNum' => (int)getVar('page'), 'error' => $error));
?>
