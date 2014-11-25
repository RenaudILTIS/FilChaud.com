<?php
	require('init.php');

	$objectQuery = $dbh->prepare('SELECT id, name, object_id FROM objects_files WHERE id = :id');
	$objectQuery->execute(array(':id' => getVar('id')));
	$object = $objectQuery->fetch();
	$objectQuery->closeCursor();

	// Check if object exists...
	if ($object['id'])
	{
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.$object['name']);
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: '.filesize('files/'.$object['object_id'].'/'.$object['name']));
	    ob_clean();
	    flush();
	    readfile('files/'.$object['object_id'].'/'.$object['name']);
	    die();
	}
?>