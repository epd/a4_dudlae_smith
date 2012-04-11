<?php
/**
 * @file
 * Log a user out.
 */
unset($_SESSION);
session_destroy();
header("Location: /login");
exit();
