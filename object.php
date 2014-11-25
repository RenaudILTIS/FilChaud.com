<?php
	require('init.php');

	$objectQuery = $dbh->prepare('SELECT objects.id, objects.name, objects.user_id, objects.description, objects.score, objects.votes, objects.raw_material, licences.name AS licence, categories.name AS category, wires.name AS wire FROM objects LEFT JOIN licences ON objects.licence_id = licences.id LEFT JOIN wires ON objects.hot_wire_id = wires.id LEFT JOIN categories ON objects.category_id = categories.id WHERE objects.id = :id');
	$objectQuery->execute(array(':id' => getVar('id')));
	$object = $objectQuery->fetch();
	$objectQuery->closeCursor();

	if (getVar('nickname') && getVar('email') && getVar('comment'))
	{
		$addCommentQuery = $dbh->prepare('INSERT INTO comments (nickname, email, comment, ip, object_id) VALUES (:nickname, :email, :comment, :ip, :object_id)');
		$addCommentQuery->execute(array(':nickname' => getVar('nickname'), ':email' => getVar('email'), ':comment' => getVar('comment'), ':ip' => $_SERVER['REMOTE_ADDR'], ':object_id' => getVar('id')));
	}
	else if (getVar('action') == 'like')
	{
		$likeQuery = $dbh->prepare('UPDATE objects SET score = score + 1, votes = votes + 1 WHERE id = :id');
		$likeQuery->execute(array(':id' => getVar('id')));
	}
	else if (getVar('action') == 'dislike')
	{
		$dislikeQuery = $dbh->prepare('UPDATE objects SET score = score - 1, votes = votes + 1 WHERE id = :id');
		$dislikeQuery->execute(array(':id' => getVar('id')));
	}

	$commentsQuery = $dbh->prepare('SELECT nickname, comment, email FROM comments WHERE object_id = :id');
	$commentsQuery->execute(array(':id' => getVar('id')));
	$comments = $commentsQuery->fetchAll();
	$commentsQuery->closeCursor();

	$picturesQuery = $dbh->prepare('SELECT file, description FROM objects_pictures WHERE object_id = :id AND file != "image.jpg"');
	$picturesQuery->execute(array(':id' => getVar('id')));
	$pictures = $picturesQuery->fetchAll();
	$picturesQuery->closeCursor();

	$videosQuery = $dbh->prepare('SELECT url, description FROM objects_videos WHERE object_id = :id');
	$videosQuery->execute(array(':id' => getVar('id')));
	$videos = $videosQuery->fetchAll();
	$videosQuery->closeCursor();

	$filesQuery = $dbh->prepare('SELECT id, name FROM objects_files WHERE object_id = :id');
	$filesQuery->execute(array(':id' => getVar('id')));
	$files = $filesQuery->fetchAll();
	$filesQuery->closeCursor();

	$userQuery = $dbh->prepare('SELECT users.id AS id, users.login AS login FROM users JOIN objects ON users.id = objects.user_id WHERE objects.id = :id');
	$userQuery->execute(array(':id' => getVar('id')));
	$user = $userQuery->fetch();
	$userQuery->closeCursor();

	$percentage = ($object['score'] > 0)? ($object['score']/$object['votes'])*100 : 0;

	render('object', array('object' => $object, 'comments' => $comments, 'files' => $files, 'user' => $user, 'pictures' => $pictures, 'videos' => $videos, 'percentage' => (int)$percentage));
?>