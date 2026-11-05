<?php

session_start();

// Clear all session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to customer login
header("Location: login.php");
exit;