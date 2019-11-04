<?php
session_start();
print_r($_SESSION);

require_once 'tweets.php';

$follow_list = parseFollowList($_POST['follow']);

require_once 'Dao.php';
$dao = new Dao();

if (isset($_SESSION['user_id'])) {
	$dao->saveSettings($_SESSION['user_id'], $follow_list);
}

$_SESSION['follow'] = $follow_list;
$_SESSION['follow_errors'] = [];

foreach ($follow_list as $account) {
	if (preg_match("/^[\w_]+$/", $account) == false) {
		$_SESSION['follow_errors'][] = 'Unexpected characters in account ' . $account . '. Separate account names with spaces.';
	}
}

header("Location: settings.php");

?>