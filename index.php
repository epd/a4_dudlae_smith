<?php
/**
 * @file
 * Assignment 3
 * Web Systems Development
 *
 * Evan Dudla <dudlae@rpi.edu>
 * Mykola Smith <smithm20@rpi.edu>
 */

session_start();

// Holds database configuration and other options
require_once __DIR__ . "/system/config.inc.php";

// If exists, load in config file from root (this will override settings from system)
if (file_exists(__DIR__ . "/config.inc.php")) {
  require_once __DIR__ . "/config.inc.php";
}

// Includes helper functions for loading in pages
require_once __DIR__ . "/system/lib/utilities.php";

// Parse our routes and grab the current path
$routes = parse_routes();
$path = parse_path();

// Get the current configuration for the route and initialize cache
$state = $routes[$path];
$cache = array();

// Grab our layout template and cache it
if (!isset($state[0])) {
  die("Error: You must provide a default layout for this route.");
}
$layout = template_cache($state[0]);

// Include our "before" logic (if exists)
if (isset($state['before']) && !empty($state['before'])) {
  foreach ($state['before'] as $file) {
    if (!file_exists(PRELOAD_DIR . $file . '.php')) {
      die("Error: Could not include file in before filter.");
    }
    require_once PRELOAD_DIR . $file . '.php';
  }
}

// Parse each region (if exists) and throw them in the cache
if (isset($state['regions']) && !empty($state['regions'])) {
  array_map("template_cache", $state['regions']);
}

// Go through our cache and construct our page
foreach ($state['regions'] as $region => $file) {
  parse_region($region, $file);
}

// Include our "after" logic (if exists)
if (isset($state['after']) && !empty($state['after'])) {
  foreach ($state['after'] as $file) {
    if (!file_exists(POSTLOAD_DIR . $file . '.php')) {
      die("Error: Could not include file in after filter.");
    }
    require_once POSTLOAD_DIR . $file . '.php';
  }
}

// Render our page
echo $layout;
