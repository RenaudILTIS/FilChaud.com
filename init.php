<?php
    if ($_SERVER['HTTP_HOST'] == 'localhost')
        require('config_locale.php');
    else
        require('config.php');
    
	
	session_start();

	//Connect to DB and set some parameters...
	$dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
	$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	//Debug settings
	if (DEBUG)
	{
		ini_set('display_errors', 'On');
		error_reporting(E_ALL ^ E_NOTICE);
	    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	
	if (isset($_GET['action']) && $_GET['action'] == 'logout')
		session_destroy();

	if (! isset($_SESSION['lang']))//
	//if (!$_SESSION['lang'])
		$_SESSION['lang'] = ($_SERVER['HTTP_HOST'] == 'www.frenchfoam.com')? 'en' : 'fr';
	if (isset($_GET['lang']))
		$_SESSION['lang'] = ($_GET['lang'] == 'fr')? 'fr' : 'en';

	// Get categories for header' menu
	$categoriesQuery = $dbh->prepare('SELECT id, name FROM categories ORDER BY id');
	$categoriesQuery->execute();
	$categories = $categoriesQuery->fetchAll();
	$categoriesQuery->closeCursor();

	$cmsQuery = $dbh->prepare('SELECT id, name FROM cms ORDER BY id');
	$cmsQuery->execute();
	$cmsPages = $cmsQuery->fetchAll();
	$cmsQuery->closeCursor();

	//Useful functions.
	require('lib.php');
?>
