<?php
	require('init.php');

	if (getVar('id'))
	{
		$pageQuery = $dbh->prepare('SELECT content FROM cms WHERE id = :id');
		$pageQuery->execute(array(':id' => getVar('id')));
	}
	else if (getVar('name'))
	{
		$pageQuery = $dbh->prepare('SELECT content FROM cms WHERE name = :name');
		$pageQuery->execute(array(':name' => getVar('name')));
	}
	else
		render('404');

	$cmsContent = $pageQuery->fetch();
	$pageQuery->closeCursor();

	if (!$cmsContent['content'])
		render('404');

	render('cms', array('cmsContent' => $cmsContent['content']));
?>