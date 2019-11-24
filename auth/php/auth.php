<?php
	$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

	$pass = md5($pass."brvfdd345");

	require '../sql/connect.php';

	$result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
	$user = $result->fetch_assoc();
	$hm = is_array($user) ? count($user) : 0;
	if ($hm == 0){
	echo "Такой пользователь не найден!";

	exit();
	}

	setcookie('user', $user['name'], time() + 3600, "/projects/auth/");


	$mysql->close();

	header('Location: /projects/auth');
?>