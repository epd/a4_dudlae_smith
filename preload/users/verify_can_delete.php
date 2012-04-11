<?php
/**
 * @file
 * Verify that user has permission to delete links.
 */

if (!$_SESSION['user']['can_delete']) {
  $check = $pdo->prepare("SELECT l.user FROM links l WHERE l.id = (?)");
  $check->execute(array($query[1]));
  $check = $check->fetch(PDO::FETCH_ASSOC);

  if (!isset($check['user']) || $check['user'] != $_SESSION['user']['id']) {
    header("Location: /");
    exit(1);
  }
}
