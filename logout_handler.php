<?php
session_start();
session_destroy();
header("Location: settings.php");
exit
?>