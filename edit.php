<?php
	session_start();
	if(!isset($_SESSION["user"])) header('Location: index.php');
?>
<!doctype html>
<html lang="se">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Soloäventyr - Redigera</title>
	<link href="https://fonts.googleapis.com/css?family=Merriweather|Merriweather+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav id="navbar">
	<a href="index.php">Hem</a>
	<a href="play.php?page=1">Spela</a>
</nav>
<form method="POST" id="loginForm" action="index.php">
	Username:<input type="text" name="username" id="username" autocomplete="off">
	<input type="submit" name="login" id="login" value="Logga In">
	<br>Password:<input type="password" name="password" id="password">
	<input type="submit" name="logOut" value="Logga Ut">
</form>
<main class="content">
	<section>
		<h1>Redigera</h1>
		<form method="post">
					<label for="page">Page:</label>
					<input type="number" name="page" id="page" min="1" max="100">
					<input type="submit" id="submit" name="submit">
					<input type="submit" id="add" name="add" value='Lägg till'>
		</form>
<?php

		include 'include/dbinfo.php';

		$dbh = new PDO('mysql:host=localhost;dbname=soloäventyr;charset=utf8mb4', $dbuser, $dbpass);

		if(isset($_POST['submit'])){
			$filteredNumber = filter_input(INPUT_POST, "page", FILTER_VALIDATE_INT);

			$stmt = $dbh->prepare("SELECT * FROM story WHERE id = :id");
			$stmt->bindparam(':id', $filteredNumber);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			echo "<p>" . $row['text'] . "</p>";

			echo "<label>Text:
						<br><textarea id='textEdit' name='textEdit' form='textForm'>" . $row['text'] . "</textarea>
						<br><form method='post' id='textForm' name='textForm'>
							<input type='hidden' name='page' id='page' value=" . $filteredNumber . ">
							<input type='submit' name='textEditSubmit'>
							<input type='submit' name='delete' value='Ta bort'>
						</form>";

			$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = :id");
			$stmt->bindparam(':id', $filteredNumber);
			$stmt->execute();

			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach($row as $value){
				echo "<form method='POST' name='storyLinks'>
							<br><textarea name='story' class='storydshit'>" . $value['text'] . "</textarea>
							<br><input type='submit' name='storyLinksSubmit'>
							<input type='hidden' name='storyId' value=" . $value['id'] . ">
							</form>";
			}
		}

		if(isset($_POST['storyLinksSubmit'])){
				$update = $_POST['story'];
				$stmt = $dbh->prepare("UPDATE storylinks SET text= :storyText WHERE id = :id");
				$stmt->bindparam(':id', $_POST['storyId']);
				$stmt->bindparam(':storyText', $_POST['story']);
				$stmt->execute();
		}
		if(isset($_POST['textEditSubmit'])){
				$filteredNumber = filter_input(INPUT_POST, "page", FILTER_VALIDATE_INT);
				$update = $_POST['textEdit'];
				$stmt = $dbh->prepare("UPDATE story SET text= :textEdit WHERE id = :id");
				$stmt->bindparam(':id', $filteredNumber);
				$stmt->bindparam(':textEdit', $update);
				$stmt->execute();
		}
		if(isset($_POST['delete'])){
				$filteredNumber = filter_input(INPUT_POST, "page", FILTER_VALIDATE_INT);
				$stmt = $dbh->prepare("DELETE FROM story WHERE id = :id");
				$stmt->bindparam(':id', $filteredNumber);
				$stmt->execute();
		}
		if(isset($_POST['add'])){
				echo "<label>Text:
							<br><textarea id='textAdd' name='textAdd' form='textForm'></textarea>
							<br><form method='post' id='textForm' name='textForm'>
								<input type='submit' name='textAddSubmit'>
							<form>";
		}
		if(isset($_POST['textAddSubmit'])){
				$update = $_POST['textAdd'];
				$stmt = $dbh->prepare("INSERT INTO story(text) VALUES (:textAdd)");
				$stmt->bindparam(':textAdd', $update);
				$stmt->execute();
		}
?>
</main>
<script src="js/navbar.js"></script>
</body>
</html>
