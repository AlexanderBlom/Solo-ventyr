<?php
	session_start();
?>
<!doctype html>
<html lang="se">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Soloäventyr</title>
	<link href="https://fonts.googleapis.com/css?family=Merriweather|Merriweather+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav id="navbar">
	<a class="active" href="index.php">Hem</a>
	<a href="play.php?page=1">Spela</a>
</nav>
<form method="POST" id="loginForm">
	Username:<input type="text" name="username" id="username" autocomplete="off">
	<input type="submit" name="login" id="login" value="Logga In">
	<br>Password:<input type="password" name="password" id="password">
	<input type="submit" name="register" id="register" value="Registrera">
</form>
<main class="content">
	<section>
		<h1>Soloäventyr - La Traviata</h1>
		<p>Välkommen till sidan om...</p>
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
<script src="js/navbar.js"></script>
</body>
</html>
