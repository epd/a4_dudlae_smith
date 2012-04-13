<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo APP_NAME; ?></title>
 
    <link rel="stylesheet" href="https://raw.github.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
	<div id="container">
		<header>
	    <h1><?php echo APP_NAME; ?></h1>
	    <?php if(isset($_SESSION['user'])): ?>
	    <p>What's up, <i><?php echo $_SESSION['user']['username']; ?></i>?
	      <?php if($_SESSION['user']['can_create']): ?>
	      <a href="/create">Add Link</a>
	      <?php endif; ?>
	      <a href="/logout">Logout</a>
	    </p>
	    <?php else: ?>
	    <p>Hey there, stranger! <a href="/login">Login</a></p>
	    <?php endif; ?>
	    </header>
		<div id="content">
	    {{ body }}
		</div>
	</div>
  </body>
</html>
