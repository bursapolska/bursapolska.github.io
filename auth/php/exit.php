<?php
	setcookie('user', $user['name'], time() - 3600, "/projects/auth/");
	header('Location: /projects/auth');
?>