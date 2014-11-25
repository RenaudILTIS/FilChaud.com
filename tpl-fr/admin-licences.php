<div class="container row">
  <h2>Admin -- Licences</h2>
  <form class="form-inline" method="post" action="admin-licences.php">
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
      foreach($licences as $licence)
      {
        echo '<tr>';
        echo '<td>'.$licence['id'].'</td>';
        echo '<td>'.$licence['name'].'</td>';
        echo '<td><a href="admin-licences.php?delete='.$licence['id'].'">Delete</a></td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
</div>
