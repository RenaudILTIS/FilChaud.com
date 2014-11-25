<div class="container row">
  <h2>Password Reset</h2>
  <?php if ($ret) echo '<div class="alert alert-success">Password changed!</div>'; ?>
  <?php if ($error) echo '<div class="alert alert-success">'.$error.'</div>'; ?>
  <p>Change password</p>
  <form method="post" action="reset.php">
    <input type="hidden" name="uuid" value="<?php echo $uuid?>">
    <input type="hidden" name="id" value="<?php echo $id?>">
    <input type="password" name="newpass1" class="form-control" placeholder="New password">
    <input type="password" name="newpass2" class="form-control" placeholder="New password (again)">
    <button class="btn btn-primary">Save</button>
  </form>
</div>