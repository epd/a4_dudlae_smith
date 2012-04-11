<?php
/**
 * @file
 * Verify that user is logged in.
 */

if (!isset($_SESSION['user'])) {
  header("Location: /login");
  exit();
}
