<div class="container row">
  <h2>Admin -- CMS</h2>
  <a class="btn btn-primary" href="admin-cms.php?action=add">Add</a>
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach($pages as $page)
      {
        echo '<tr>';
        echo '<td>'.$page['id'].'</td>';
        echo '<td>'.$page['name'].'</td>';
        echo '<td><a href="admin-cms.php?action=edit&id='.$page['id'].'">Edit</a> -- <a href="admin-cms.php?delete='.$page['id'].'">Delete</a></td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
</div>