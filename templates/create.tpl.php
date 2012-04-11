<?php if (!empty($_SESSION['errors'])): ?>
<ul>
  <?php foreach ($_SESSION['errors'] as $error): ?>
  <li><?php echo $error; ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<form method="post" action="">
  <p><label for="title">Title:</label>
    <input type="text" name="title" id="title"></p>

  <p><label for="description">Description:</label>
    <input type="text" name="description" id="description"></p>

  <p><label for="url">URL:</label>
    <input type="text" name="url" id="url"></p>

  <p><button type="submit">Create Link</button></p>
</form>
