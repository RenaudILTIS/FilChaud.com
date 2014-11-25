<?php

	require('init.php');
	
	$error = NULL;
	if (getVar('uuid') && filter_var(getVar('uuid'), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[a-zA-Z\-\s]+/"))) )
	{
		$checkQuery = $dbh->prepare('SELECT id_user as id FROM pass_reset WHERE clef = :uuid and used=0 and timediff(dh_insert, now()) < 20 limit 1;');
		$checkQuery->execute(array(':uuid' => getVar('uuid')));
		
		$check = $checkQuery->fetch();
		$checkQuery->closeCursor();
		
		if ($check['id'] == '')
			$error = (getLang() == 'en') ? 'error in the link' : 'lien erron&eacute;';
		else
		{
		    if (getVar('id') == $check['id'])
		    {
		        if (getVar('newpass1') != getVar('newpass2'))
		            render('reset', array('uuid' => getVar('uuid'), 'id' => getVar('id'), 'error' => (getLang() == 'fr')? 'Les mots de passe ne correspondent pas.' : 'Password don\'t match'));
		        
		        $editUserQuery = $dbh->prepare('UPDATE users SET password = :password WHERE id = :id');
		        $editUserQuery->execute(array(':password' => passwordHash(getVar('newpass1')),':id' => getVar('id')));
		        
		        $KillKey = $dbh->prepare('UPDATE pass_reset SET used=1, dh_used=now() WHERE clef = :uuid');
		        $KillKey->execute(array(':uuid' => getVar('uuid')));
		        
		        $error=(getLang() == 'fr')? 'Mot de passe modifi&eacute avec succ&egrave;s':'Password changed successfully.';
		    
		    } else 
		      render('reset', array('uuid' => getVar('uuid'), 'id' => $check['id'])); //premier lancement page reset
		}
		
	}
	else
		$error = (getLang() == 'en')? 'incorrect UUID' : 'UUID incorrect';

	$objectsQuery = $dbh->prepare('SELECT id, name, description FROM objects ORDER BY id DESC LIMIT :start,:count');
	$objectsQuery->execute(array(':start' => (getVar('page'))?(int)getVar('page')*OBJECTS_PER_PAGE:0, ':count' => OBJECTS_PER_PAGE));
	$objects = $objectsQuery->fetchAll();
	$objectsQuery->closeCursor();
	render('index', array('objects' => $objects, 'error' => $error));
?>
