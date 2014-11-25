<?php
	require('init.php');

	$objectsQuery = $dbh->prepare('SELECT id, name, description FROM objects ORDER BY id DESC LIMIT :start,:count');
	$objectsQuery->execute(array(':start' => (getVar('page'))?(int)getVar('page')*OBJECTS_PER_PAGE:0, ':count' => OBJECTS_PER_PAGE));
	$objects = $objectsQuery->fetchAll();
	$objectsQuery->closeCursor();
	$nbobjects = $dbh->query("SELECT COUNT(id) FROM objects")->fetchColumn();

	render('index', array('objects' => $objects, 'pageNum' => (int)getVar('page'), 'nbobjects' => $nbobjects));
?>
