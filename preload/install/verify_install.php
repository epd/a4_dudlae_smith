<?php
/**
 * @file
 * Install verification.
 *
 * Makes sure the user has installed via the supplied script and the
 * appropriate information is intact in the database.
 */
if (!isset($_SESSION['installed']) || !$_SESSION['installed']) {
  try {
    $query = $pdo->prepare("SELECT u.id, r.id FROM users u JOIN roles r ON (r.id = u.role) WHERE u.username = (?)");
    $query->execute(array("admin"));
  }
  catch (PDOException $e) {
    header("Location: /install");
    exit();
  }
  $check = $query->fetch(PDO::FETCH_ASSOC);
  if (empty($check) || count($check) != 1) {
    header("Location: /install");
    exit();
  }
  $_SESSION['installed'] = TRUE;
}
