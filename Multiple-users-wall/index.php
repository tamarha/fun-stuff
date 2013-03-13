<?php
	include 'connect.php';

	if (!isset($_SESSION)) {
			session_start();
		}	

	if (isset($_SESSION['logged'])) {
		header('location:wall.php?id='.$_SESSION['id']);
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Homepage Wall - PHP</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php
		if (isset($_SESSION['errors'])) {
			echo "<div id='errors'>";
			foreach ($_SESSION['errors'] as $message) {
				echo '<p>'.$message.'</p>';
			}
			echo "</div>";
		}
		if (isset($_SESSION['messages'])) {
			echo "<div id='session_messages'>";
			foreach ($_SESSION['messages'] as $message) {
				echo '<p>'.$message.'</p>';
			}
			echo "</div>";
		}
	?>
	<div class="form">
		<h3>Register:</h3>
		<form action="process.php" method="post" id='register'>
			<label for="name">Name</label>
			<input type="text" name="name" />
			<label for="email">Email</label>
			<input type="text" name="email" />
			<label for="password">Password</label>
			<input type="password" name="password" />
			<input type="hidden" name="action" value="register" />
			<input type="submit" value="Register" />
		</form>
	</div>

	<div class="form">
		<h3>Login:</h3>
		<form action="process.php" method="post" id='login'>
			<label for="email">Email</label>
			<input type="text" name="email" />
			<label for="password">Password</label>
			<input type="password" name="password" />
			<input type="hidden" name="action" value="login" />
			<input type="submit" value="Login" />
		</form>		
	</div>
</body>
</html>
<?php
	unset($_SESSION['errors']);
	unset($_SESSION['messages']);
?>