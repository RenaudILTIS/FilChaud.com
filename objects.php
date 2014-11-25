<?php
	require('init.php');

	if (getVar('category'))
	{
		$objectsQuery = $dbh->prepare('SELECT id, name, description FROM objects WHERE category_id = :category_id ORDER BY id DESC  LIMIT :start,:count');
		$objectsQuery->execute(array(':category_id' => getVar('category'), ':start' => (getVar('page'))?(int)getVar('page')*OBJECTS_PER_PAGE:0, ':count' => OBJECTS_PER_PAGE));
		$objects = $objectsQuery->fetchAll();
		$objectsQuery->closeCursor();

		$title = (getLang() == 'fr')? 'Objet de la categorie' : 'Category\'s objects';
	}
	else if (getVar('search'))
	{
		$objectsQuery = $dbh->prepare('SELECT id, name, description FROM objects WHERE name LIKE :search ORDER BY id DESC  LIMIT :start,:count');
		$objectsQuery->execute(array(':search' => '%'.getVar('search').'%', ':start' => (getVar('page'))?(int)getVar('page')*OBJECTS_PER_PAGE:0, ':count' => OBJECTS_PER_PAGE));
		$objects = $objectsQuery->fetchAll();
		$objectsQuery->closeCursor();

		$title = (getLang() == 'fr')? 'Resultats de la recherche' : 'Search results';
	}
	else if (getVar('user'))
	{
		$objectsQuery = $dbh->prepare('SELECT id, name, description FROM objects WHERE user_id = :user_id ORDER BY id DESC  LIMIT :start,:count');
		$objectsQuery->execute(array(':user_id' => getVar('user'), ':start' => (getVar('page'))?(int)getVar('page')*OBJECTS_PER_PAGE:0, ':count' => OBJECTS_PER_PAGE));
		$objects = $objectsQuery->fetchAll();
		$objectsQuery->closeCursor();

		$title = (getLang() == 'fr')? 'Objets de l\'utilisateur' : 'User\'s objects';
	}

	render('objects', array('objects' => $objects, 'pageNum' => getVar('page'), 'title' => $title));
?>