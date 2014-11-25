<div class="container row">
  <h2>Admin -- Wires</h2>
  <form class="form-inline" method="post" action="admin-wires.php">
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
      foreach($wires as $wire)
      {
        echo '<tr>';
        echo '<td>'.$wire['id'].'</td>';
        echo '<td>'.$wire['name'].'</td>';
        echo '<td><a href="admin-wires.php?delete='.$wire['id'].'">Delete</a></td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
</div>
