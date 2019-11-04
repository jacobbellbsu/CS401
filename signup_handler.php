<?php
session_start();
$username = trim($_POST['username']);
$password = $_POST['password'];

require_once 'Dao.php';
$dao = new Dao();

$_SESSION['username'] = $username;

if ($username == '') {
	$_SESSION['error'] = 'Username needed';
}
else if (strlen($username) >= 256) {
	$_SESSION['error'] = 'Username is too long. 256 characters max.';
}
else if ($password == '') {
	$_SESSION['error'] = 'Password needed';
}
else if (strlen($password) >= 64) {
	$_SESSION['error'] = 'Password is too long. 64 characters max.';
}
else if ($dao->userExists($username)) {
	$_SESSION['error'] = 'Username is not available';
}
else {
	$_SESSION['user_id'] = $dao->createUser($username, $password);
	$_SESSION['logged_in'] = true;
	unset($_SESSION['error']);
}
header("Location: settings.php");

?>