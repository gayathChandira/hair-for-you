<?php require('includes\connection.php'); ?>

<?php
session_start();

if (isset($_SESSION['name'])){
		session_unset($_SESSION['name']);
        session_unset($_SESSION['usertype']);
        session_unset($_SESSION['userID']);
		$message = base64_encode(urlencode(("Logged Out Successfully")));
		header('Location:index.php?msg=' . $message);
		exit();
	}

?>