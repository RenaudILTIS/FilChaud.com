<?php
	require('init.php');

	if (!isAdmin())
		render('403');

	if (getVar('add'))
	{
		$addCategoryQuery = $dbh->prepare('INSERT INTO categories (name) VALUES (:name)');
		$addCategoryQuery->execute(array(':name' => getVar('add')));
	}
	if (getVar('delete'))
	{
		$deleteCategoryQuery = $dbh->prepare('DELETE FROM categories WHERE id = :id');
		$deleteCategoryQuery->execute(array(':id' => getVar('delete')));
	}

	$categoriesQuery = $dbh->prepare('SELECT id, name FROM categories ORDER BY id');
	$categoriesQuery->execute();
	$categories = $categoriesQuery->fetchAll();
	$categoriesQuery->closeCursor();

	render('admin-categories', array('categories' => $categories));
?>