<h2>Links</h2>
<?php if(!empty($vars['links'])): ?>
<ul>
<?php foreach ($vars['links'] as $link): ?>
  <li>
    <a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a> &mdash; <?php echo $link['description']; ?><br /><small>Posted by <b><?php echo $link['username']; ?></b> on <?php echo date("m/d/Y @ h:ia", $link['time']); ?></small>
    <?php if (isset($_SESSION['user']['username']) && ($_SESSION['user']['can_delete'] || ($link['user'] == $_SESSION['user']['id'] && $_SESSION['user']['can_delete_own']))): ?>
    <a href="/delete/<?php echo $link['id']; ?>">Delete</a>
    <?php endif; ?>
  </li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p><em>Sorry, no links found!</em></p>
<?php endif; ?>
