<?php
/**
 * @file
 * Install verification.
 *
 * Makes sure the user has installed via the supplied script and the
 * appropriate information is intact in the database.
 */
if (!$installed) {
  header("Location: /install");
}
