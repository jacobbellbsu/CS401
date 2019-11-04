<form>
	<div>
		<?php
			echo 'Logged in as ' . htmlspecialchars($_SESSION['username']);
		?>
	</div>
	<button type="submit" formaction="logout_handler.php" formmethod="POST">Log out</button>
</form>