<?php
/**
 * @file
 * PDO connection initialization.
 *
 * Include this file on any routes that need a database connection as a
 * "before" filter.
 */

// Make sure our configuration is defined and loaded
if (!isset($config) || !isset($config['db']) || !isset($config['user']) || !isset($config['pass'])) {
  die("Error: Please make sure your database configuration is defined.");
}

// Try to make a connection
try {
    // Go ahead and create our connection!
    $pdo = new PDO(

        // If we need sockets, use them. If not, use hostname
        sprintf('mysql:host=%s;dbname=%s', 'localhost', $config['db']),

        // Authenticate with these credentials
        sprintf('%s', $config['user']),
        sprintf('%s', $config['pass'])
    );
}

// An error has occured connecting to DB
catch (PDOException $e) {
    die("Error: Could not connect to MySQL database");
}
