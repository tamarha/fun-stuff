<?php 

session_start();
include 'connect.php';

	//Validate name
	function validate_text($string) {
		if (empty($string)) {
			$_SESSION['errors'][] = "Please enter your name."; 
		}
		elseif (!ctype_alpha($string)) {
			$_SESSION['errors'][] = "Your name can only containg letters.";
		}
	}

	//Validate email
	function validate_email($string) {
		if (empty($string)) {
			$_SESSION['errors'][] = "Please enter your email address.";
		}
		elseif (!filter_var(($string), FILTER_VALIDATE_EMAIL)) {
			$_SESSION['errors'][] = "Please enter a valid email address.";
		}
	}

	//Validate password
	function validate_password($string) {
		if (empty($string)) {
			$_SESSION['errors'][] = "Please enter a password.";
		}
		elseif (strlen($string) < 6) {
			$_SESSION['errors'][] = "Your password must have at least 6 characters.";
		}
	}

	//Identify action and process the information
	if ($_POST['action'] == 'register') {
		validate_text($_POST['name']);
		validate_email($_POST['email']);
		validate_password($_POST['password']);
		if (!isset($_SESSION['errors'])) {
			$result = mysql_query("SELECT email FROM users WHERE email ='".mysql_real_escape_string($_POST['email'])."'");
			if (mysql_fetch_assoc($result) == NULL) {
				$insert_query = "INSERT INTO users (name, email, password) VALUES ('".mysql_real_escape_string($_POST['name'])."','".mysql_real_escape_string($_POST['email'])."','".md5(mysql_real_escape_string($_POST['password']))."')";
				mysql_query($insert_query);
				$_SESSION['messages'][] = "Registration completed";
				header('location:index.php');
			}
			else {
				$_SESSION['errors'][] = "Email address is already registered.";
				header('location:index.php');
			}
		}
		else {
			header('location:index.php');
		}
	}
	elseif ($_POST['action'] == 'login') {
		validate_email($_POST['email']);
		validate_password($_POST['password']);
		if (!isset($_SESSION['errors'])) {
			$query = "SELECT * FROM users WHERE email = '".mysql_real_escape_string($_POST['email'])."' AND password = '".md5(mysql_real_escape_string($_POST['password']))."'";
			$user = mysql_query($query);
			$valid_user = mysql_fetch_array($user);
			if (is_null($valid_user)) {
				$_SESSION['errors'][] = "Email and password do not match";
			}
			else {
				$_SESSION['id'] = $valid_user['user_id'];
				$_SESSION['email'] = $valid_user['email'];
				$_SESSION['name'] = $valid_user['name'];
				$_SESSION['logged'] = TRUE;
				if ($_SESSION['logged'] === TRUE) {
					header('location:wall.php?id='.$_SESSION['id']);
				}
			}
		}
		else {
			header('location:index.php');
		}
	}
	elseif ($_POST['action'] == 'post_message') {
		$query = "INSERT INTO messages (user_id, parent_id, message, wall_id) VALUES ('".$_SESSION['id']."','NULL','".$_POST['message']."', '".$_POST['wall_id']."')";
		mysql_query($query);
		header('location:wall.php?id='.$_POST['wall_id']);
	}
	elseif ($_POST['action'] == 'post_comment') {
		$query = "INSERT INTO messages (user_id, parent_id, message) VALUES ('".$_SESSION['id']."','".$_POST['parent_id']."','".$_POST['message']."')";
		mysql_query($query);
		header('location:wall.php?id='.$_POST['wall_id']);
	}
	elseif ($_POST['action'] == 'delete'){
		$query = "DELETE FROM messages WHERE message_id =".$_POST['message_id'];
		mysql_query($query);
		header('location:wall.php?id='.$_POST['wall_id']);
	}
	elseif ($_POST['action'] == 'edit'){
		$query = "UPDATE messages SET message = '".$_POST['message_content']."' WHERE  message_id =".$_POST['message_id'];
		mysql_query($query);
		header('location:wall.php?id='.$_POST['wall_id']);
	}
	else {
		session_destroy();
		header('location:index.php');
	}

?>