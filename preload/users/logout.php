<?php
/**
 * @file
 * Log a user out.
 */
unset($_SESSION['username']);
session_destroy();
header("Location: /login");
exit();
