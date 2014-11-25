<div class="container row">
  <h2>My profil</h2>
  <?php if ($ret) echo '<div class="alert alert-success">Mot de passe modifie!</div>'; ?>
  <?php if ($error) echo '<div class="alert alert-success">'.$error.'</div>'; ?>
  <p>Change password</p>
  <form method="post" action="profil.php">
    <input type="text" name="oldpass" class="form-control" placeholder="Old password">
    <input type="text" name="newpass1" class="form-control" placeholder="New password">
    <input type="text" name="newpass2" class="form-control" placeholder="New password (again)">
    <button class="btn btn-primary">Save</button>
  </form>
</div>