<?php
/**
 * @file
 * Performs installation.
 */

// Check if we actually need to install
if (isset($_SESSION['installed']) && $_SESSION['installed']) {
  header("Location: /");
  exit();
}

// Execute our schema
$pdo->exec($schema);

// If everything went well, go to index
$_SESSION['installed'] = TRUE;
