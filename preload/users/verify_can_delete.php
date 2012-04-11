<?php
/**
 * @file
 * Verify that user has permission to delete links.
 */

if (!isset($_SESSION['user'])) {
  header("Location: /login");
  exit();
}
