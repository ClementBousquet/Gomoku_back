<?php
require_once('entities/game.php');
require_once('entities/gomoku.php');
require_once('entities/player.php');

//this will store their information as they refresh the page
session_start();

if (!isset($_SESSION['game']['gomoku']))
	$_SESSION['game']['gomoku'] = new gomoku();

?>
<!doctype html>
<html>
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="inc/style.css" />
		<title>Gomoku</title>
	</head>
	<body>
		<main role="main">
			<div class="jumbotron">
				<h1 class="display-4">Gomoku</h1>
			</div>
			<div class="container">
				<div class="row">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					<?php
						$_SESSION['game']['gomoku']->playGame($_POST);
					?>
					</form>
				</div>
			</div>
		</main>
		<footer class="page-footer">
			<div class="footer-copyright text-center py-3">© 2020 Copyright
  		</div>
		</footer>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>
