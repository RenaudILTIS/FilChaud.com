<?php
	require('init.php');

	if (!isAdmin())
		render('403');

	if (getVar('add'))
	{
		$addWireQuery = $dbh->prepare('INSERT INTO wires (name) VALUES (:name)');
		$addWireQuery->execute(array(':name' => getVar('add')));
	}
	if (getVar('delete'))
	{
		$deleteWireQuery = $dbh->prepare('DELETE FROM wires WHERE id = :id');
		$deleteWireQuery->execute(array(':id' => getVar('delete')));
	}

	$wiresQuery = $dbh->prepare('SELECT id, name FROM wires ORDER BY id');
	$wiresQuery->execute();
	$wires = $wiresQuery->fetchAll();
	$wiresQuery->closeCursor();

	render('admin-wires', array('wires' => $wires));
?>