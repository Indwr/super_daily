<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("localhost", "sonu", "password", "milk");
  $mysqli->set_charset("utf8mb4");
} catch(Exception $e) {
  error_log($e->getMessage());
  //Should be a message a typical user could understand
}
    
  $set = $mysqli->query("SELECT * FROM `setting`")->fetch_assoc();
	date_default_timezone_set($set['timezone']);
	$main = $mysqli->query("SELECT * FROM `tbl_rmilk`")->fetch_assoc();
?>