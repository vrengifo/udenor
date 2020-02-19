<?php
		session_start();
		session_unregister('session_username');
		//session_destroy();
		header("location:index.php");
?>
