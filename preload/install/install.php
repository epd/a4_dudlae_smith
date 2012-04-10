<?php
/**
 * @file
 * Performs installation.
 */
try {
  $pdo->beginTransaction();
  $pdo->exec($schema);
  $pdo->commit();
}
catch (PDOException $e) {
  $pdo->rollback();
  die("Error: Could not perform installation");
}
$_SESSION['installed'] = TRUE;
header("Location: /");
exit();
