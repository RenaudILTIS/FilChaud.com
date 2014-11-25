<div class="container row">
  <h2>Admin -- Categories</h2>
  <form class="form-inline" method="post" action="admin-categories.php">
    <input type="text" name="add" class="form-control" placeholder="Name">
    <button class="btn btn-primary">Add</button>
  </form>
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
      foreach($categories as $category)
      {
        echo '<tr>';
        echo '<td>'.$category['id'].'</td>';
        echo '<td>'.$category['name'].'</td>';
        echo '<td><a href="admin-categories.php?delete='.$category['id'].'">Delete</a></td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
</div>
