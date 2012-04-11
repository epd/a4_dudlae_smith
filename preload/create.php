<?php
/**
 * @file
 * Process link creation.
 */

// Holds all our creation errors
$_SESSION['errors'] = array();

// If we are trying to POST, process the data
if (!empty($_POST)) {

  // Check if any fields are empty, if so: produce error
  if (empty($_POST['title']) || empty($_POST['url']) || empty($_POST['description'])) {
    $_SESSION['errors'][] = "Please fill in all fields.";
  }

  // Make sure the URL is valid
  if (!preg_match("/(http|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:\/~\+#]*[\w\-\@?^=%&amp;\/~\+#])?/", $_POST['url'])) {
    $_SESSION['errors'][] = "Please provide a valid URL.";
  }

  // If no errors, proceed
  if (empty($_SESSION['errors'])) {
    // Prepare and execute the insert statement
    $create = $pdo->prepare("INSERT INTO links (title, description, url, time, uniqid, user) VALUES (?, ?, ?, ?, ?, ?)");
    $create->execute(array($_POST['title'], $_POST['description'], $_POST['url'], time(), sha1(uniqid(mt_rand(), true)), $_SESSION['user']['id']));
    $create->closeCursor();

    // If no errors occurred, go back to the index
    if ($pdo->errorCode() == 0) {
      header("Location: /");
      exit(1);
    }

    // Else, produce error message
    $_SESSION['errors'][] = "Could not create link. Please try again.";
  }
}
