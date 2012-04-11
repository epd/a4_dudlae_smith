<?php
/**
 * @file
 * Check for login submission.
 */

// This will hold all of our login errors
$_SESSION['errors'] = array();

// If we are trying to login, go ahead and process it
if (!empty($_POST)) {

  // If no username/password provided go ahead and error out
  if (empty($_POST['username']) || empty($_POST['password'])) {
    $_SESSION['errors'][] = "Please provide both a username and password.";
  }

  // If no errors so far, continue
  if (empty($_SESSION['errors'])) {
    // Grab the salt for the user based on the username provided
    $query = $pdo->prepare("SELECT u.salt FROM users u WHERE u.username = (?)");
    $query->execute(array($_POST['username']));
    $salt = $query->fetch(PDO::FETCH_ASSOC);
    $query->closeCursor();

    // If this user exists and we can get the salt, go ahead and verify their password
    if (isset($salt['salt']) && !empty($salt['salt'])) {
      $query = $pdo->prepare("SELECT u.username, u.role FROM users u WHERE u.username = (?) AND u.password = (?)");
      $query->execute(array($_POST['username'], sha1($salt['salt'] . $_POST['password'])));
      $verify = $query->fetch(PDO::FETCH_ASSOC);
      $query->closeCursor();

      // If their password is correct, redirect to the index
      if (isset($verify['username']) && isset($verify['role'])) {
        $_SESSION['user'] = $verify;
        header("Location: /");
        exit();
      }
    }
    // Otherwise, produce an invalid authentication error
    $_SESSION['errors'][] = "Invalid username and/or password provided.";
  }
}