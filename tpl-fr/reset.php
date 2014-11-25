<div class="container row">
  <h2>Reset</h2>
  <?php if ($ret) echo '<div class="alert alert-success">Mot de passe modifie!</div>'; ?>
  <?php if ($error) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
  <p>Changer le mot de passe</p>
  <form method="post" action="reset.php">
    <input type="hidden" name="uuid" value="<?php echo $uuid?>">
    <input type="hidden" name="id" value="<?php echo $id?>">
    <input type="password" name="newpass1" class="form-control" placeholder="Nouveau mot de passe">
    <input type="password" name="newpass2" class="form-control" placeholder="Nouveau mot de passe (verification)">
    <button class="btn btn-primary">Enregistrer</button>
  </form>
</div>