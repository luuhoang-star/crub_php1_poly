<?php 
session_start();
session_destroy();
header("location: login.php");
exit; // Add exit to stop further execution
?>
