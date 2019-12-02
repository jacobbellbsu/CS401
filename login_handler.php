<?php
session_start();
$username = trim($_POST['username']);
$password = md5($_POST['password'] . '9001');

require_once 'Dao.php';
$dao = new Dao();

$_SESSION['username'] = $username;

if ($username == '') {
	$_SESSION['error'] = 'Username needed';
}
else if ($password == '') {
	$_SESSION['error'] = 'Password needed';
}
else if ($dao->userExists($username) == false) {
	$_SESSION['error'] = 'No user found with this username';
}
else if ($dao->validLogin($username, $password)) {
	$_SESSION['user_id'] = $dao->getUserID($username);
	$_SESSION['logged_in'] = true;
	$_SESSION['follow'] = $dao->getFollowList($_SESSION['user_id']);
	unset($_SESSION['error']);
}
else {
	$_SESSION['error'] = "Incorrect password";
}
header("Location: settings.php");
?>