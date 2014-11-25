<?php
	require('init.php');

	if (!isAdmin())
		render('403');

	if (getVar('action') == 'add')
	{
		if (getVar('name'))
		{
			$addPageQuery = $dbh->prepare('INSERT INTO cms (name, content) VALUES (:name, :content)');
			$addPageQuery->execute(array(':name' => getVar('name'), ':content' => getVar('content', false)));
		}
		else
			render('admin-cms-editor', array('action' => 'add'));
	}
	else if (getVar('action') == 'edit')
	{
		if (getVar('name'))
		{
			$editPageQuery = $dbh->prepare('UPDATE cms SET name = :name, content = :content WHERE id = :id');
			$editPageQuery->execute(array(':name' => getVar('name'), ':content' => getVar('content', false), ':id' => getVar('id')));
		}
		else
		{
			$pageQuery = $dbh->prepare('SELECT id, name, content FROM cms WHERE id = :id');
			$pageQuery->execute(array(':id' => getVar('id')));
			$cmsContent = $pageQuery->fetch();
			$pageQuery->closeCursor();
			render('admin-cms-editor', array('action' => 'edit', 'cmsContent' => $cmsContent));
		}
	}
	else if (getVar('delete'))
	{
		$deleteLicenceQuery = $dbh->prepare('DELETE FROM cms WHERE id = :id');
		$deleteLicenceQuery->execute(array(':id' => getVar('delete')));
	}

	$pagesQuery = $dbh->prepare('SELECT id, name FROM cms ORDER BY id');
	$pagesQuery->execute();
	$pages = $pagesQuery->fetchAll();
	$pagesQuery->closeCursor();

	render('admin-cms', array('pages' => $pages));
?>
