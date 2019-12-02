<?php
	session_start();
	require_once("tweets.php");
	if (!isset($_SESSION['follow'])) {
		$_SESSION['follow'] = getDefaultFollowList();
	}
?>

<html>
	<header>
		<title>Minimal Tweets</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" href="style.css">
	</header>
	<body>
		<div class="header">
			<button onclick="location.href='settings.php'">Settings</button>
			<img src="logo.png">
		</div>
		<?php
			showTweets();
		?>
		</div>
		<?php
			include_once("footer.html");
		?>
	</body>
</html>