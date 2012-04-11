<?php
/**
 * @file
 * Log a user out.
 */
unset($_SESSION['user']);
session_destroy();
header("Location: /login");
exit();
