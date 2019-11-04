<?php
	require_once 'tweets.php';
	session_start();
	if (!isset($_SESSION['follow'])) {
		$_SESSION['follow'] = getDefaultFollowList();
	}
?>

<html>
	<header>
		<title>Minimal Tweets - Settings</title>
		<link rel="stylesheet" href="style.css">
	</header>
	<body>
		<div class="header">
			<button onclick="location.href='index.php'">Home</button>
			<img src="logo.png">
		</div>
		<div class="settings">
			<div class="settings_section">
				<?php
					if (isset($_SESSION['logged_in'])) {
						include_once("logout.php");
					}
					else {
						include_once("login.php");
					}
				?>
			</div>
			<div class="settings_section">
				<form>
					<p>Accounts to follow</p>
					<textarea rows="10" class="input_field" name="follow"><?php
						foreach ($_SESSION['follow'] as $account) {
							echo htmlspecialchars($account) . '
';
						}
					?></textarea>
					<?php
						if (isset($_SESSION['follow_errors'])) {
							foreach ($_SESSION['follow_errors'] as $error) {
								echo '<div class="error">' . $error . '</div>';
							}
						}
					?>
					<button type="submit" formaction="save_settings_handler.php" formmethod="POST">Save</button>
				</form>
			</div>
		</div>
		<?php include_once("footer.html");?>
	</body>
</html>