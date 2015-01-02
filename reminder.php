<?php
	require('init.php');
    
	$error = NULL;
	if (getVar('email') && filter_var(getVar('email'), FILTER_VALIDATE_EMAIL) )
	{
		//$password = passwordHash(getVar('pass1'));
		$checkQuery = $dbh->prepare('SELECT id, login FROM users WHERE email = :email limit 1;');
		$checkQuery->execute(array(':email' => getVar('email')));
		$check = $checkQuery->fetch();
		$checkQuery->closeCursor();
		if ($check['id'] == '')
			$error = (getLang() == 'en')? 'If your email was in the base, you will receive a reset link shorly.' : 'Si l\'email &eacute;tait pr&eacute;sent dans notre base, vous allez recevoir un lien pour ecraser votre mot de passe sous peu, merci de v&eacute;rifier votre r&eacute;pertoire ind&eacute;sirable.';
		else
		{
		    //$clef=com_create_guid();
		    $clef=uniqid('', true);
		    $clef=str_replace('{','',$clef);
		    $clef=str_replace('}','',$clef);
			$reminderQuery = $dbh->prepare('INSERT INTO pass_reset (email, clef, ipv4, dh_insert, id_user) VALUES (:email, :clef, :ipv4, now(), :id_user)');
			//:email, :clef, :ipv4, :dh_insert, :id_user
			$reminderQuery->execute(array(':email' => getVar('email'), ':clef' => $clef, ':ipv4' => $_SERVER['REMOTE_ADDR'], ':id_user' => $check['id']));
			
			// fonction mail();
			$from  = "contact@filchaud.com";
			$JOUR  = date("Y-m-d");
			$HEURE = date("H:i");
			(getLang() == 'en')? 
			         $Subject = "Password Reset HOTWIREPROJECTS.COM - $JOUR $HEURE"
			        :$Subject = "Reset de mot de passe FILCHAUD.COM - $JOUR $HEURE";
			
			$mail_Data = "";
			$mail_Data .= "<html> \n";
			$mail_Data .= "<head> \n";
			(getLang() == 'en')? $mail_Data .= "<title> Password Reset </title> \n" : $mail_Data .= "<title> Reset de mot de passe </title> \n";
			$mail_Data .= "</head> \n";
			$mail_Data .= "<body> \n";
			
			
			(getLang() == 'en')? $mail_Data .= "A request to reset your password has been performed on the www.filchaud.com site with this email address.":$mail_Data .="Une demande de reset de mot de passe a été effectuée sur le site www.filchaud.com avec cette adresse email.";
			$mail_Data .= "<br> \n";
			(getLang() == 'en')? $mail_Data .= "If you are not the author of this request, please ignore it.":$mail_Data .="Si vous n'êtes pas l'auteur de cette demande, merci de ne pas en tenir compte.";
			$mail_Data .= "<br> \n";
			$mail_Data .= "<br> \n";
			$mail_Data .= "Login : ".$check['login'];
			$mail_Data .= "<br> \n";
			(getLang() == 'en')? $mail_Data .= "Thanks to click the following link to reset your password":$mail_Data .= "Merci de cliquer sur le lien suivant pour &eacute;craser votre mot de passe";
			$mail_Data .= "<br> \n";
			$mail_Data .= "<a href='http://".$_SERVER['HTTP_HOST']."/reset.php?uuid=".$clef."&'>";
			$mail_Data .= "http://".$_SERVER['HTTP_HOST']."/reset.php?uuid=".$clef."&<br> \n";
			$mail_Data .= "</a>";
			$mail_Data .= "<br> \n";
			
			$mail_Data .= "</body> \n";
			$mail_Data .= "</HTML> \n";
			
			$headers  = "MIME-Version: 1.0 \n";
			$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
			$headers .= "From: $from  \n";
			//$headers .= "Disposition-Notification-To: $from  \n";
			
			// Message de Priorité haute
			// -------------------------
			$headers .= "X-Priority: 1  \n";
			$headers .= "X-MSMail-Priority: High \n";
			
			$CR_Mail = TRUE;
			$CR_Mail = @mail (getVar('email'), $Subject, $mail_Data, $headers);
			
			if ($CR_Mail === FALSE)   
			    $error = (getLang() == 'en')? 'Error sending the mail, please try again later or email us.':'Erreur lors de l\'exp&eacute;dition du mail, merci de reessayer plus tard ou de nous &eacute;crire directement.';
			else
			    $error = (getLang() == 'en')? 'If your email was in the base, you will receive a reset link shorly.' : 'Si l\'email &eacute;tait pr&eacute;sent dans notre base, vous allez recevoir un lien pour ecraser votre mot de passe sous peu, merci de v&eacute;rifier votre r&eacute;pertoire ind&eacute;sirable.';
		}
	}
	else if (!filter_var(getVar('email'), FILTER_VALIDATE_EMAIL))
		$error = (getLang() == 'en')? 'Invalid email' : 'Email invalide';
	else
		$error = (getLang() == 'en')? 'All fields are required' : 'Tous les champs sont obligatoire';

	
	$objectsQuery = $dbh->prepare('SELECT id, name, description FROM objects ORDER BY id DESC LIMIT :start,:count');
	$objectsQuery->execute(array(':start' => (getVar('page'))?(int)getVar('page')*OBJECTS_PER_PAGE:0, ':count' => OBJECTS_PER_PAGE));
	$objects = $objectsQuery->fetchAll();
	$objectsQuery->closeCursor();
	render('index', array('objects' => $objects, 'error' => $error));
?>
