<?php
/**
 * @file
 * Gets list of links.
 */

$links = $pdo->query("SELECT l.*, u.username FROM links l JOIN users u ON (u.id = l.user) ORDER BY l.time DESC");
$vars['links'] = $links->fetchAll(PDO::FETCH_ASSOC);
$links->closeCursor();
