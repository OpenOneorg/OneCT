<?php
	require_once "../include/config.php";

	unset($_SESSION['user']);

	header("Location: index.php");