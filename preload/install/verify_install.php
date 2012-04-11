<?php
/**
 * @file
 * Install verification.
 *
 * Makes sure the user has installed via the supplied script and the
 * appropriate information is intact in the database.
 */
if (!isset($_SESSION['installed']) || !$_SESSION['installed']) {
  $query = $pdo->prepare("SELECT u.id, r.id  FROM users u RIGHT JOIN roles r ON (r.id = u.role) WHERE u.username = (?)");
  if ($pdo->errorCode() != 0) {
    header("Location: /install");
    exit();
  }
  $query->execute(array("admin"));
  $check = $query->fetch(PDO::FETCH_ASSOC);
  $query->closeCursor();
  if (!$check) {
    header("Location: /install");
    exit();
  }
  $_SESSION['installed'] = TRUE;
}
