<?php
	require('init.php');

	if (getVar('newpass1'))
	{
		if (getVar('newpass1') != getVar('newpass2'))
			render('profil', array('error' => (getLang() == 'fr')? 'Les mots de passe ne correspondent pas.' : 'Password don\'t match'));

		$getUserQuery = $dbh->prepare('SELECT count(id) AS count FROM users WHERE password = :password');
		$getUserQuery->execute(array(':password' => passwordHash(getVar('oldpass'))));
		$user = $getUserQuery->fetch();
		$getUserQuery->closeCursor;

		if (!$user['count'])
			render('profil', array('error' => (getLang() == 'fr')? 'Mot de passe incorrect' : 'Invalid password'));

		$editUserQuery = $dbh->prepare('UPDATE users SET password = :password WHERE id = :id');
		$editUserQuery->execute(array(':password' => passwordHash(getVar('newpass1')),':id' => $_SESSION['id']));
		render('profil', array('ret' => true));

	}

	render('profil');
?>