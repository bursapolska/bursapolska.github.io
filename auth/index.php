<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Страница авторизации</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="container mt-4">
			<?php 
				if (!empty($_COOKIE['user']) == ''): 
			?>
			<div class="row">
				<div class="col">
					<h1>Форма регистрации</h1>
				<form action="php/register.php" method="post">
					<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
					<input type="text" class="form-control" name="name" id="name" placeholder="Введите имя"><br>
					<input type="password" class="form-control" name="pass" id="pass" placeholder="Введите пароль"><br>
					<button class="btn btn-success" type="submit">Зарегистрировать</button>
				</form>
				</div>
				<div class="col">
				<h1>Форма авторизации</h1>
				<form action="php/auth.php" method="post">
					<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
					<input type="password" class="form-control" name="pass" id="pass" placeholder="Введите пароль"><br>
					<button class="btn btn-success" type="submit">Авторизоваться</button>
				</form>
				</div>
			<?php else: ?>
				<p>Привет <?=$_COOKIE['user']?>. Чтобы выйти нажмите <a href="php/exit.php">здесь</a>.</p>
			<?php endif; ?>
			</div>
		</div>
	</body>
</html>