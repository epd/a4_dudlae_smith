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

// Try to execute our schema
try {
  $pdo->beginTransaction();
  foreach ($schema as $sql) {
    $pdo->exec($sql);
  }
  $pdo->commit();
}
// An error occurred so rollback!
catch (PDOException $e) {
  $pdo->rollback();
  die("Error: Could not perform installation");
}

// If everything went well, go to index
$_SESSION['installed'] = TRUE;
header("Location: /");
exit();
