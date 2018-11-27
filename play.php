<?php
	session_start();
?>
<!doctype html>
<html lang="se">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Soloäventyr - Spela</title>
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
			<div class="header">
				<h1>Spela</h1>
			</div>
		</div>
<?php
	include_once 'include/dbinfo.php';

	// PDO

	$dbh = new PDO('mysql:host=localhost;dbname=soloäventyr;charset=utf8mb4', $dbuser, $dbpass);

	if (isset($_GET['page'])) {
		// TODO load requested page from DB using GET
		// prio before session
		// set session to remember
		$filteredPage = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);

		$stmt = $dbh->prepare("SELECT * FROM story WHERE id = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo "<div class='container'> 
				<div class='row justify-content-md-center'>
						<p>" . $row['text'] . "</p>
				</div>
				<div class='row justify-content-md-center'>";

		$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetchall(PDO::FETCH_ASSOC);

		foreach ($row as $val) {
			echo "
					<div class='row px-2'>
						<div class='col-2'>
							<button type='button' class='btn btn-outline-dark'><a href='?page='" . $val['target'] . ">" . $val['text'] . "<br> </a></button>
						</div>
						</div>";

		}
		echo "
			</div>
			</div>";

	} elseif(isset($_SESSION['page'])) {
		// TODO load page from db
		// use for returning player / cookie
	} else {
		// TODO load start of story from DB
	}

?>
</main>
</body>
</html>
