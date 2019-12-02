<form>
	<label for="username">Username:</label>
	<input type="text" name="username" <?php if (isset($_SESSION['username'])) echo 'value="' . $_SESSION['username'] . '"' ?>>
	<label for="password">Password:</label>
	<input type="password" name="password">
	<?php
		if (isset($_SESSION['error'])) {
			echo '<div class="error">';
			echo $_SESSION['error'];
			echo '</div>';
		}
	?>
	<button type="submit" formaction="login_handler.php" formmethod="POST">Log in</button>
	<button type="submit" formaction="signup_handler.php" formmethod="POST">Sign up</button>
</form>