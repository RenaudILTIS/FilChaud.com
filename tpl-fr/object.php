<div class="container row">
  <div class="col-sm-8 blog-main">
    <div class="blog-post row">
      <h2 class="blog-post-title"><?php echo $object['name']; ?></h2>
        <div class="object-image col-sm-4">
          <a href="<?php echo (file_exists('files/'.$object['id'].'/image.jpg'))?'files/'.$object['id'].'/image.jpg':'img/nofile.png'; ?>"><img src="<?php echo (file_exists('files/'.$object['id'].'/image.jpg'))?'files/'.$object['id'].'/image.jpg':'img/nofile.png'; ?>" alt="Image introuvable"></a>
        </div>
        <?php
          foreach($pictures as $picture)
          {
            echo '<div class="object-image col-sm-4">';
            echo '  <a href="files/'.$object['id'].'/'.$picture['file'].'"><img src="files/'.$object['id'].'/'.$picture['file'].'" alt="Picture"></a>';
            echo '  <span>'.$picture['description'].'</span>';
            echo '</div>';
          }
          foreach($videos as $video)
          {
            echo '<div class="object-image col-sm-4">';
            echo '   <iframe src="//www.youtube.com/embed/'.parse_yturl($video['url']).'" frameborder="0" allowfullscreen></iframe>';
            echo '   <span>'.$video['description'].'</span>';
            echo '</div>';
          }
        ?>
      <p><?php echo nl2br($object['description']); ?></p>
    </div>
    <hr>
    <?php
        $cmtx_parameters = 'id';
		$cmtx_identifier = 'cmtx_url';
        $cmtx_reference = 'cmtx_title';
        $cmtx_path = 'commentics/';
        require $cmtx_path . 'includes/commentics.php'; //don't edit this line
    ?>
    <!-- 
    <div class="object-comments row">
      <h3>Commentaires</h3>
      <?php
      if (!empty($comments))
        foreach($comments as $comment)
        {
          echo '<div class="media" style="padding-left: 15px;">';
          echo '<a class="pull-left" href="#"><img class="media-object" src="http://www.gravatar.com/avatar/'.md5(strtolower(trim($comment['email']))).'"/> </a>';
          echo '<div class="media-body">';
          echo '<h4 class="media-heading">De '.$comment['nickname'].':</h4>';
          echo '<p><small>'.$comment['comment'].'</small></p>';
          echo '</div>';
          echo '</div>';
        }
      else
        echo 'Aucun commentaire';
      ?>
    </div>
    <br />
    <div class="add-comment">
      <h4>Ajouter un commentaire</h4>
      <form method="post" action="object.php?id=<?php echo $_GET['id']; ?>">
        <div class="input-group">
          <span class="input-group-addon">#</span>
          <input name="nickname" type="text" class="form-control" placeholder="Pseudo">
        </div>
        <div class="input-group">
          <span class="input-group-addon">@</span>
          <input name="email" type="text" class="form-control" placeholder="Email">
        </div>
        <textarea name="comment" class="form-control" rows="3" placeholder="Votre commentaire"></textarea>
        <button class="btn btn-primary">Commenter</button>
      </form>
    </div>
    -->
  </div>

  <div class="col-sm-3 col-sm-offset-1 object-sidebar">
    <div class="sidebar-module sidebar-module-inset">
      <h4>De <em><?php echo $user['login']; ?></em></h4>
      <p><a href="objects.php?user=<?php echo $user['id']; ?>">Voir d'autre objets de cet utilisateur</a></p>
      <!-- 
      <?php
        if (!$_GET['action'])
          echo '<p>'.$percentage.'% de votes positif<br /><a href="object.php?action=like&id='.$_GET['id'].'"><span class="glyphicon glyphicon-thumbs-up"></span></a> <a href="object.php?action=dislike&id='.$_GET['id'].'"><span class="glyphicon glyphicon-thumbs-down"></span></a></p>';
        else
          echo '<p>Merci pour votre retour!</p>';
      ?>
      -->
      <ul class="nostyle specs">
        <li>Catégorie: <?php echo $object['category']; ?></li>
        <li>Licence: <?php echo $object['licence']; ?></li>
        <li>Matériau recommandé: <?php echo $object['raw_material']; ?></li>
        <li>Machine recommandée: <?php echo $object['wire']; ?></li>
      </ul>
    </div>
    <div class="sidebar-module sidebar-module-inset">
      <h4>Fichiers &agrave; t&eacute;l&eacute;charger</h4>
      <?php
        foreach($files as $file) {
            //echo '<p>'.$file['name'].' <a href="download.php?id='.$file['id'].'"><span class="glyphicon glyphicon-download"></span></a></p>';
            echo '<p><a href="download.php?id='.$file['id'].'">';
            echo '<button type="button" class="btn btn-default btn-lg" data-original-title="T&eacute;l&eacute;charger" data-placement="left">';
                //echo '<span class="glyphicon glyphicon-download"></span> T&eacute;l&eacute;charger';
                echo '<span class="glyphicon glyphicon-download"></span>&nbsp;&nbsp;'.$file['name'];
            echo '</button>';
            echo '</a></p>';
        }
      ?>
    </div>
	<?php if ($_SESSION['id'] && ($object['user_id'] == $_SESSION['id'] || isAdmin())) { ?>
        <div class="sidebar-module sidebar-module-inset">
          <h4>Actions</h4>
          <p><a href="editobject.php?edit=<?php echo $_GET['id']; ?>">Editer</a> -- <a href="editobject.php?delete=<?php echo $_GET['id']; ?>">Supprimer</a></p>
        </div>
    <?php } ?>
    <div class="sidebar-module">
      <h4>Partager</h4>
      <ol class="list-unstyled">
        <li><a href="http://twitter.com/share?text=Un projet a été publié par <?php echo $user['login']; ?> sur filchaud!&url=http://www.filchaud.com/object.php?id=<?php echo $_GET['id']; ?>">Twitter</a></li>
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://www.filchaud.com?object.php?id=<?php echo $_GET['id']; ?>">Facebook</a></li>
        <li><a href="https://plus.google.com/share?url=http://www.filchaud.com?object.php?id=<?php echo $_GET['id']; ?>">Google +</a></li>
      </ol>
    </div>
  </div>
  
   
   
   
</div>