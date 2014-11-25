<div class="container row">
  <h2>Mon profil</h2>
  <?php if ($ret) echo '<div class="alert alert-success">Mot de passe modifie!</div>'; ?>
  <?php if ($error) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
  <p>Changer le mot de passe</p>
  <form method="post" action="profil.php">
    <input type="text" name="oldpass" class="form-control" placeholder="Ancien mot de passe">
    <input type="text" name="newpass1" class="form-control" placeholder="Nouveau mot de passe">
    <input type="text" name="newpass2" class="form-control" placeholder="Nouveau mot de passe (verification)">
    <button class="btn btn-primary">Enregistrer</button>
  </form>
</div>