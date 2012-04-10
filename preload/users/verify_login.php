<?php
/**
 * @file
 * Verify that user is logged in.
 */

if (!isset($_SESSION['username'])) {
  header("Location: /login");
  exit();
}
