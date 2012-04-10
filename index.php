<?php
/**
 * @file
 * Assignment 3
 * Web Systems Development
 *
 * Evan Dudla <dudlae@rpi.edu>
 * Mykola Smith <smithm20@rpi.edu>
 */

// Holds database configuration and other options
require_once "system/config.inc.php";

// Includes helper functions for loading in pages
require_once "system/lib/utilities.php";

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

// Parse each region (if exists) and throw them in the cache
if (isset($state['regions']) && !empty($state['regions'])) {
  array_map("template_cache", $state['regions']);
}

// Go through our cache and construct our page
foreach ($state['regions'] as $region => $file) {
  parse_region($region, $file);
}

// Render our page
echo $layout;
