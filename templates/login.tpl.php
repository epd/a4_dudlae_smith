<?php if (!empty($_SESSION['errors'])): ?>
<ul>
  <?php foreach ($_SESSION['errors'] as $error): ?>
  <li><?php echo $error; ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>
<form method="post" action="">
  <p><label for="username">Username:</label>
    <input type="text" name="username" id="username"></p>

  <p><label for="password">Password:</label>
    <input type="password" name="password" id="password"></p>

  <p><button type="submit">Login</button></p>
</form>
