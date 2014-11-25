<?php
	require('init.php');

	if (!isAdmin())
		render('403');

	render('admin-general');
?>