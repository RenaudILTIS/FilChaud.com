<div class="container row">
  <h2>Admin -- File types</h2>
  <form class="form-inline" method="post" action="admin-types.php">
    <input type="text" name="add" class="form-control" placeholder="Name">
    <input type="text" name="extension" class="form-control" placeholder=".ext">
    <input type="text" name="mimetype" class="form-control" placeholder="Mime/Type">
    <button class="btn btn-primary">Add</button>
  </form>
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Extension</th>
      <th>Mime type</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach($types as $type)
      {
        echo '<tr>';
        echo '<td>'.$type['id'].'</td>';
        echo '<td>'.$type['name'].'</td>';
        echo '<td>'.$type['extension'].'</td>';
        echo '<td>'.$type['mimetype'].'</td>';
        echo '<td><a href="admin-types.php?delete='.$type['id'].'">Delete</a></td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
</div>
