<div class="container row">
  <h2>Admin -- Users</h2>
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>E-mail</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach($users as $user)
      {
        echo '<tr>';
        echo '<td>'.$user['id'].'</td>';
        echo '<td>'.$user['login'];
        if ($user['is_admin'])
          echo '  <span class="btn-danger">Admin</span>';
        echo '</td>';
        echo '<td>'.$user['email'].'</td>';
        echo '<td><a href="admin-users.php?delete='.$user['id'].'">Delete</a></td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
</div>