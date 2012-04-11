<?php
/**
 * @file
 * Delete links if admin
 */

$delete = $pdo->prepare("DELETE FROM links WHERE id = (?)");
$delete->execute(array($query[1]));
$delete->closeCursor();

header("Location: /");
exit();
