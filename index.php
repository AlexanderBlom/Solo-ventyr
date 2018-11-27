<?php
	session_start();
?>
<!doctype html>
<html lang="se">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Soloäventyr</title>
	<link href="https://fonts.googleapis.com/css?family=Niramit" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark">
	<ul class="nav">
		<li><a class="navbar-brand nav-link" href="index.php">Hem</a></li>
		<li><a class ="navbar-brand nav-link" href="play.php?page=1">Spela</a></li>
	</ul>
	
		<form method="POST" id="loginForm" class="ml-auto">
			<input type="text" name="username" id="username" autocomplete="off" placeholder="Username" class="m-1">
			<button type="submit" name="login" id="login" class="mr-2 btn btn-outline-light">Logga in</button>
			<input type="password" name="password" id="password" placeholder="Password " class="m-1">
			<button type="submit" name="register" id="register" class="btn btn-outline-light">Registrera</button>
		</form>
</nav>
<main class="content">
	<div class="container">
		<section>
			<h1>Soloäventyr - La Traviata</h1>
			<img alt="LaNjure" src="media/La_Njure.svg" width="200" height="200">
		</section>
	</div>
</main>
<?php
	include 'include/dbinfo.php';

	$dbh = new PDO('mysql:host=localhost;dbname=soloäventyr;charset=utf8mb4', $dbuser, $dbpass);

	if(isset($_POST['register'])){
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$stmt = $dbh->prepare("INSERT INTO login(username, password) VALUES (:username, :password)");
		$stmt->bindparam('username', $username);
		$stmt->bindparam('password', $password);
		$stmt->execute();
		}

		if(isset($_POST['login'])){
			$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
			$password = $_POST['password'];

			$stmt = $dbh->prepare("SELECT * FROM login WHERE username = :username");
			$stmt->bindparam(':username', $username);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if($username == $row['username'] &&
			password_verify($password, $row['password'])){
				$_SESSION["user"] = $username;
				header('Location: /webbserverprog/SoloÄventyr/story/edit.php');
			}
			else{$message = "Fel användarnamn eller Lösenord";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
		if(isset($_POST['logOut'])){
			session_destroy();
		}
?>
</main>
</body>
</html>
