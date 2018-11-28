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
	<link href="https://fonts.googleapis.com/css?family=Niramit" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark ">
	<ul class="nav">
		<li><a class="navbar-brand nav-link" href="index.php">Hem</a></li>
		<li><a class ="navbar-brand nav-link" href="play.php?page=1">Spela</a></li>
	</ul>	
	<form method="POST" id="loginForm" class="ml-auto">
	<?php
		if(isset($_SESSION["user"])){
			echo "<button type='submit' name='logOut' id='logOut' class='btn btn-outline-light'>Logga ut</button>";
			}
	?>
	</form>
</nav>

<main class="content">
		<div class="container">
			<h1>Redigera</h1>
			<div class="row">
				<div class="col-2 form-group">
					<form method="post">
						<label for="page">Page:</label>
						<input class='form-control border-dark' type="number" name="page" id="page" min="1" max="100">
						<input class='form-control' type="submit" id="submit" name="submit">
						<input class='form-control' type="submit" id="add" name="add" value='Lägg till'>
					</form>
				</div>
<?php

		include 'include/dbinfo.php';

		$dbh = new PDO('mysql:host=localhost;dbname=soloäventyr;charset=utf8mb4', $dbuser, $dbpass);

		if(isset($_POST['submit'])){
			$filteredNumber = filter_input(INPUT_POST, "page", FILTER_VALIDATE_INT);

			$stmt = $dbh->prepare("SELECT * FROM story WHERE id = :id");
			$stmt->bindparam(':id', $filteredNumber);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			echo "
					<div class='col-5 mt-4 mr-2'>
						<p> Texten på sidan:<br>" . $row['text'] . "</p>
					</div>
					</div>";

			echo "
					<div class='row'>
						<div class='col'>
							<label>Text:</label>
							<br><textarea id='textEdit' class='form-control border-dark' name='textEdit' form='textForm' cols='150' rows='7'>" . $row['text'] . "</textarea>
							<br><form method='post' id='textForm' name='textForm'>
								<input type='hidden' class='form-control' name='page' id='page' value=" . $filteredNumber . ">
								<input type='submit' class='form-control' name='textEditSubmit'>
								<input type='submit' class='form-control' name='delete' value='Ta bort'>
							</form>
						</div>";

			$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = :id");
			$stmt->bindparam(':id', $filteredNumber);
			$stmt->execute();

			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach($row as $value){
				echo "
						<div class='col'>
							<form method='POST' name='storyLinks'>
								<label>Länk:</label>
								<br><textarea name='story' class='form-control border-dark' cols='150' rows='7'>" . $value['text'] . "</textarea>
								<br><input type='submit' class='form-control' name='storyLinksSubmit'>
								<input type='hidden' name='storyId' value=" . $value['id'] . ">
							</form>
						</div>";
			}
			echo "</div>
					</div>";
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
				echo "<label>Text:</label>
							<br><textarea id='textAdd' name='textAdd' form='textForm'></textarea>
							<br><form method='post' id='textForm' name='textForm'>
								<input type='submit' name='textAddSubmit'>
								</form>
							</div>";
		}
		if(isset($_POST['textAddSubmit'])){
				$update = $_POST['textAdd'];
				$stmt = $dbh->prepare("INSERT INTO story(text) VALUES (:textAdd)");
				$stmt->bindparam(':textAdd', $update);
				$stmt->execute();
		}
		if(isset($_POST['logOut'])){
			session_destroy();
			header('Location: /webbserverprog/SoloÄventyr/story/index.php');
		}
?>
</main>
</body>
</html>