<?php
/*
Copyright © 2009-2014 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!isset($cmtx_path)) { die('Access Denied.'); }

if (cmtx_setting('task_enabled_delete_bans')) {
require_once $cmtx_path . 'includes/tasks/delete_bans.php'; //load task to delete bans
}

if (cmtx_setting('task_enabled_delete_comments')) {
require_once $cmtx_path . 'includes/tasks/delete_comments.php'; //load task to delete comments
}

if (cmtx_setting('task_enabled_delete_reporters')) {
require_once $cmtx_path . 'includes/tasks/delete_reporters.php'; //load task to delete reporters
}

if (cmtx_setting('task_enabled_delete_subscribers')) {
require_once $cmtx_path . 'includes/tasks/delete_subscribers.php'; //load task to delete subscribers
}

if (cmtx_setting('task_enabled_delete_voters')) {
require_once $cmtx_path . 'includes/tasks/delete_voters.php'; //load task to delete voters
}

?>