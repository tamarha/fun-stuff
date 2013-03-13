<?php
		session_start();


?>

<!DOCTYPE html>
<html>
<head>
	<title>Wall | AJAX</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<?php include_once'connect.php'; ?>
</head>
<body>
	<div id="logout">
		<form action='process.php' method='post'>
			<input type='hidden' name='action' value='logout'/>
			<input type='submit' value='Logout'/>
		</form>
	</div>
	<div id='users_list'>
		<h4>Select user's wall:</h4>
		<table>
			<?php
			$query = "SELECT * FROM users";
			$users = mysql_query($query);
			while ($user = mysql_fetch_assoc($users)) {
				if ($_GET['id'] == $user['user_id']) {
					echo "<tr>";
					echo "<td class='selected'><a href='wall.php?id=".$user['user_id']."'>".$user['name']."</a></td>";
					echo "</tr>";
				}
				else {
				 	echo "<tr>";
				 	echo "<td><a href='wall.php?id=".$user['user_id']."'>".$user['name']."</a></td>";
					echo "</tr>";
				}	
			 } 
			?>
		</table>	
	</div>
	<div id='wall'>
	<div class="form">
		<h3>Hi <?php echo ucfirst($_SESSION['name']); ?>!</h3>
		<form action="process.php" method="post" class="message_form">
			<label for="name">Post a message in <?php 
			$users = mysql_query("SELECT * FROM users WHERE user_id =".$_GET['id']);
			$user = mysql_fetch_assoc($users);
			echo $user['name']."'s wall."; ?>:</label><br/>
			<textarea name="message"></textarea><br/>
			<input type="hidden" name="action" value="post_message" />
			<input type="hidden" name="wall_id" value=<?php echo "'".$_GET['id']."'"?> />
			<input type="submit" name="submit" value="Submit message" />
		</form>
	</div>
		<br/><br/>
		<h2>The wall</h2>
	<div id="messages_wall">
		<?php
			$messages =  mysql_query("SELECT t1.message_id, t1.message, t1.wall_id, t1.created_at, t1.parent_id, t2.user_id, t2.name
										FROM messages AS t1 
										LEFT JOIN users as t2 ON t1.user_id = t2.user_id
										WHERE t1.wall_id = ".$_GET['id']."
										ORDER BY t1.created_at DESC");
			while ($message = mysql_fetch_assoc($messages)) {
				if ($message['parent_id'] == 0) {	
					echo "<div class='message'>";
					echo "<p class='title'>".ucfirst($message['name'])." posted at ".$message['created_at'].":</p>";
					echo "<p class='text'>".$message['message']."</p>";
					$message_time = strtotime($message['created_at']);
					$last_30min = time()-34200;
					if (($_SESSION['id'] == $message['user_id']) AND ($last_30min <= $message_time)) {
						echo "<form action='process.php' method='post' class='delete'>
							<input type='hidden' name='action' value='delete' />
							<input type='hidden' name='message_id' value='".$message['message_id']."' />
							<input type='hidden' name='wall_id' value='".$_GET['id']."' />
							<input class='delete_button' type='submit' name='delete' value='Delete'/>
							</form>
							<form action='process.php' method='post' class='edit'>
							<input type='hidden' name='action' value='edit' />
							<input type='text' name='message_content'/>
							<input type='hidden' name='message_id' value='".$message['message_id']."' />
							<input type='hidden' name='wall_id' value='".$_GET['id']."' />
							<input class='edit_button' type='submit' name='edit' value='Edit'/>
							</form>";
					}
					echo "</div>";
					echo "<form action='process.php' method='post' class='comment_form'>
								<textarea name='message'></textarea><br/>
								<input type='hidden' name='action' value='post_comment' />
								<input type='hidden' name='parent_id' value='".$message['message_id']."' />
								<input type='hidden' name='wall_id' value='".$_GET['id']."' />
								<input type='submit' value='Comment' />
							</form>";
					$comments = mysql_query("SELECT t1.message_id, t1.message, t1.created_at, t1.parent_id, t2.user_id, t2.name
									FROM messages AS t1 
									LEFT JOIN users as t2 ON t1.user_id = t2.user_id
									WHERE parent_id =".mysql_real_escape_string($message['message_id'])."
									ORDER BY t1.created_at DESC");
					while ($comment = mysql_fetch_assoc($comments)) {
						echo "<div class='comment'>";
						echo "<p class='title'>".ucfirst($comment['name'])." commented at ".$comment['created_at'].":</p>";
						echo "<p class='text'>".$comment['message']."</p>";
						$comment_time = strtotime($comment['created_at']);
						if (($_SESSION['id'] == $comment['user_id']) AND ($last_30min <= $comment_time)) {
							echo "<form action='process.php' method='post' class='delete'>
								<input type='hidden' name='action' value='delete' />
								<input type='hidden' name='message_id' value='".$comment['message_id']."' />
								<input type='hidden' name='wall_id' value='".$_GET['id']."' />
								<input class='delete_button' type='submit' name='delete' value='Delete'/>
								</form>";
							echo "<form action='process.php' method='post' class='edit'>
								<input type='hidden' name='action' value='edit' />
								<input type='text' name='message_content'/>
								<input type='hidden' name='message_id' value='".$comment['message_id']."' />
								<input type='hidden' name='wall_id' value='".$_GET['id']."' />
								<input class='edit_button' type='submit' name='edit' value='Edit'/>
								</form>";
						}
						echo "</div>";
					}
				}
			}	
		?>
	</div>
	</div>

</body>
</html>