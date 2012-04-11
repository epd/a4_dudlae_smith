<?php
/**
 * @file
 * Verify that user has permission to create links.
 */

if (!$_SESSION['user']['can_create']) {
  header("Location: /");
  exit();
}
