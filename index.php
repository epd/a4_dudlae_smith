<?php
/**
 * @file
 * Assignment 3
 * Web Systems Development
 *
 * Evan Dudla <dudlae@rpi.edu>
 */

// Holds database configuration and other options
require_once "system/config.inc.php";

// Include a YAML parser <http://code.google.com/p/spyc/> for our routes
require_once "system/spyc.php";
$routes = spyc_load_file('system/routes.yml');

// If for some reason the routes file is missing, throw an error
if (isset($routes[0]) && $routes[0] == 'system/routes.yml') {
  die("Error: Invalid routes file or file not found.");
}

// We need at least a root route defined by default
if (!isset($routes['/']) || empty($routes['/'])) {
  die("Error: You need to define a route for <tt>/</tt>.");
}

// Parse our path and get the appropriate route
$uri = parse_url($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
$path = $uri['path'];

// Keep trying routes to get the most specific route that is valid
while (!isset($routes[$path])) {
  $path = explode('/', $path);
  array_pop($path);
  $path = implode('/', $path);

  // If the path is empty, we assume root
  if (empty($path)) {
    $path = '/';
  }
}

// Get our template
$templates = $routes[$path];
$pages = array();
while (!empty($templates)) {
  // Get the layout template we are injecting
  $file = array_shift($templates);

  // Error occurs if we can't find the file
  if (!file_exists(TEMPLATE_DIR . $file)) {
    die("Error: Could not load template file.");
  }

  // Use output buffering to do dynamic region replacement
  ob_start();
  require_once TEMPLATE_DIR . $file;
  $contents = ob_get_contents();
  ob_end_clean();

  // Cache our template
  $pages[$file] = $contents;
}

// Build the page by extending any regions
$regions = array();
if (preg_match_all('/\{\{[\s]*([a-zA-Z\.\-\_0-9]+)?[\s]*\}\}/', $pages[reset($routes[$path])], $regions) > 0) {
  foreach ($regions[1] as $key => $region) {
    $contents = str_replace($regions[0][$key], $pages[$routes[$path][$region]], $pages[reset($routes[$path])]);
  }
}
echo $contents;
