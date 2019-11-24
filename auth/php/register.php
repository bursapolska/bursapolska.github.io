<?php
	$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
	$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);

	if (mb_strlen($login) < 4 || mb_strlen($login) > 90) {
		echo "Недопустимая длинна логина!";
		exit();
	} else if (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
		echo "Недопустимая длинна имени!";
		exit();
	} else if (mb_strlen($pass) < 2 || mb_strlen($pass) > 10) {
		echo "Недопустимая длинна пароля!";
		exit();
	}

	$pass = md5($pass."brvfdd345");

	require '../sql/connect.php';

	$mysql->query("INSERT INTO `users` (`login`, `pass`, `name`) VALUES ('$login', '$pass', '$name')");

	$mysql->close();

	header('Location: /projects/auth');
?>