<?php
/**
 * @file
 * Utilities file.
 *
 * Holds helper methods for processing templates and before/after filters.
 */

// Include a YAML parser <http://code.google.com/p/spyc/> for our routes
require_once __DIR__ . "/spyc.php";

/**
 * Implements parse_routes().
 *
 * Uses the Spyc YAML library to parse our routes file.
 */
function parse_routes() {
  // Use the Spyc YAML parser to read in our routes file
  $routes = spyc_load_file(__DIR__ . '/../routes.yml');

  // If for some reason the routes file is missing, throw an error
  if (isset($routes[0]) && $routes[0] == __DIR__ . '/../routes.yml') {
    die("Error: Invalid routes file or file not found.");
  }

  // We need at least a root route defined by default
  if (!isset($routes['/']) || empty($routes['/'])) {
    die("Error: You need to define a route for <tt>/</tt>.");
  }

  return $routes;
}

/**
 * Implements parse_path().
 *
 * Returns the most specific valid path from the current location.
 */
function parse_path() {
  global $routes;

  // Parse our path and get the appropriate route
  $uri = parse_url('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
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

  // Get the query variables (everything after the path)
  $query = explode('/', substr($uri['path'], strlen($path)));
  // Remove empty indicies from the beginning
  foreach ($query AS $qk => $qv) {
    if (!empty($qv)) {
      break;
    }
    unset($query[$qk]);
  }

  return array($path, $query);
}

/**
 * Implements template_cache().
 */
function template_cache($file = NULL) {
  global $cache;
  global $vars;

  // If no arguments are passed, just return the whole cache
  if (!$file) {
    return $cache;
  }

  // Error occurs if we can't find the file
  if (!file_exists(TEMPLATE_DIR . $file . TPL_EXTENSION)) {
    die("Error: Could not load template file.");
  }

  // Use output buffering to do dynamic region replacement
  ob_start();
  require_once TEMPLATE_DIR . $file . TPL_EXTENSION;
  $contents = ob_get_contents();
  ob_end_clean();

  // Cache our template
  $cache[$file] = $contents;
  return $cache[$file];
}

/**
 * Implements parse_regions().
 */
function parse_region($region = NULL, $file = NULL) {
  // If no argument is passed, fail
  if (!$region || !$file) {
    die("Error: You must provide a region and/or file for this region.");
  }

  global $layout;
  global $cache;
  global $state;

  // Look for a match for the current region
  if (preg_match_all('/\{\{[\s]*(' . $region . ')?[\s]*\}\}/', $layout, $regions) > 0) {
    // Replace all instances with the cached version of the template
    foreach ($regions[1] as $key => $region) {
      $layout = str_replace($regions[0][$key], $cache[$file], $layout);
    }
  }
}
