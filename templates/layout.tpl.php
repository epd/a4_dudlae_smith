<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo APP_NAME; ?></title>
 
    <link rel="stylesheet" href="https://raw.github.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <h1><?php echo APP_NAME; ?></h1>
    <?php if(isset($_SESSION['user'])): ?>
    <p>What's up, <i><?php echo $_SESSION['user']['username']; ?></i>? <a href="/create">Add Link</a> <a href="/logout">Logout</a></p>
    <?php else: ?>
    <p>Hey there, stranger! <a href="/login">Login</a></p>
    <?php endif; ?>
    <hr />
    {{ body }}
  </body>
</html>
