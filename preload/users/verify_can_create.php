<?php
/**
 * @file
 * Verify that user has permission to create links.
 */

if (!isset($_SESSION['user'])) {
  header("Location: /login");
  exit();
}
