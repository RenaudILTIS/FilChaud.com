<div class="container row">
  <form action="editobject.php?edit=<?php echo $_GET['edit']; ?>" method="post">
    <div class="col-sm-8 blog-main">
      <div class="blog-post row">
        <h2 class="blog-post-title" style="padding-left: 15px;"><input type="text" class="form-control" name="name" value="<?php echo $object['name']; ?>" /></h2>
            <div class="object-image col-sm-4">
              <a href="<?php echo (file_exists('files/'.$object['id'].'/image.jpg'))?'files/'.$object['id'].'/image.jpg':'img/nofile.png'; ?>"><img src="<?php echo (file_exists('files/'.$object['id'].'/image.jpg'))?'files/'.$object['id'].'/image.jpg':'img/nofile.png'; ?>" alt="Image introuvable"></a>
            </div>
            <?php
              foreach($pictures as $picture)
              {
                echo '<div class="object-image col-sm-4">';
                echo '  <a href="files/'.$object['id'].'/'.$picture['file'].'"><img src="files/'.$object['id'].'/'.$picture['file'].'" alt="Picture"></a>';
                echo '  <span>'.$picture['description'].' <button class="btn btn-danger delete-picture" picture="'.$picture['id'].'"><span class="glyphicon glyphicon-remove"></span></button></span>';
                echo '</div>';
              }
              foreach($videos as $video)
              {
                echo '<div class="object-image col-sm-4">';
                echo '   <iframe src="//www.youtube.com/embed/'.parse_yturl($video['url']).'" frameborder="0" allowfullscreen></iframe>';
                echo '   <span>'.$video['description'].'<button class="btn btn-danger delete-video" video="'.$video['id'].'"><span class="glyphicon glyphicon-remove"></span></button></span>';
                echo '</div>';
              }
            ?>
            <div class="col-sm-8">
              <div class="addMedia">
            <button class="btn btn-sm btn-success add-picture" data-element="picture-element"><span class="glyphicon glyphicon-plus"></span> Picture</button>
            <button class="btn btn-sm btn-success add-video" data-element="picture-element"><span class="glyphicon glyphicon-plus"></span> Video</button>
          </div>
        </div>
        <p class="row"><textarea class="form-control" name="description" rows="15" cols="45"><?php echo nl2br($object['description']); ?></textarea></p>
      </div>
    </div>

    <div class="col-sm-3 col-sm-offset-1 object-sidebar">
       <div class="sidebar-module sidebar-module-inset">
        <h4>Files</h4>
        <?php
           foreach($files as $file)
             echo '<p>'.$file['name'].' <a href="editobject.php?deleteFile='.$file['id'].'" class="delete-file"><span class="glyphicon glyphicon-remove"></span></a></p>';
          ?>
           <button class="btn btn-sm btn-success add-object" data-element="picture-element"><span class="glyphicon glyphicon-plus"></span></button>
      </div>
      <div class="sidebar-module sidebar-module-inset">
        <h4>Specs</h4>
        <ul class="nostyle specs">
          <li>
            Category:
            <select name="category">
              <?php foreach ($categories as $category) echo '<option value="'.$category['id'].'" '.(($category['id'] == $object['category_id'])?'selected="selected"':'').'>'.$category['name'].'</option>'; ?>
            </select>
          </li>
          <li>
            Licence:
            <select name="licence">
              <?php foreach ($licences as $licence) echo '<option value="'.$licence['id'].'" '.(($licence['id'] == $object['licence_id'])?'selected="selected"':'').'>'.$licence['name'].'</option>'; ?>
            </select>
          </li>
          <li>
            Recommanded material:
            <input type="text" class="form-control" name="raw_material" value="<?php echo $object['raw_material']; ?>"/>
          </li>
          <li>
            Recommanded machine:
            <select name="wire">
              <?php foreach ($wires as $wire) echo '<option value="'.$wire['id'].'" '.(($wire['id'] == $object['hot_wire_id'])?'selected="selected"':'').'>'.$wire['name'].'</option>'; ?>
            </select>
          </li>
        </ul>
      </div>
      <div class="sidebar-module sidebar-module-inset">
        <h4>Edit</h4>
        <p><button class="btn btn-sm btn-success">Save</button> <a class="btn btn-sm btn-danger" href="object.php?id=<?php echo $_GET['edit']; ?>">Cancel</a></p>
      </div>
    </div>
  </form>
</div>

<div id="add-file" style="display: none;">
  <form action="editobject.php?newObject=true" method="post" class='newFile-form'>
    <input type="file" class="form-control" data-filename-placement="inside">
    <input type="text" class="form-control" placeholder="Comment">
  </form>
</div>
<div id="add-picture" style="display: none;">
  <form action="editobject.php?newPicture=true" method="post" class='new-picture-form'>
    <input type="file" class="form-control" data-filename-placement="inside">
    <input type="text" class="form-control" placeholder="Comment">
  </form>
</div>
<div id="add-video" style="display: none;">
  <form method="post" class='new-video-form'>
    <input type="text" name="url" class="form-control" placeholder="url">
    <input type="text" name="comment" class="form-control" placeholder="Comment">
  </form>
</div>

<script type="text/javascript">
  $('.carousel').carousel({'interval': 360000});
  $('select').selectpicker();

  $('input[type=file]').bootstrapFileInput();

  $('.container').delegate('.delete-file', 'click', function(e)
  {
    $(this).parent().remove();
    $.ajax({url: $(this).attr('href')});
    e.preventDefault();
  });

  $('.delete-video').click(function(e){
    e.preventDefault();
    var button = $(this);
    $.ajax({
      url: 'editobject.php?deletevideo='+button.attr('video'),
      success: function()
      {
        button.parent().parent().remove();
      }
    });
  });

  $('.container').delegate('.delete-picture', 'click', function(e)
  {
    e.preventDefault();
    var button = $(this);
    $.ajax({
      url: 'editobject.php?deletepicture='+button.attr('picture'),
      success: function()
      {
        button.parent().parent().remove();
      }
    });
  });

  // Handle the new file update
  $('.add-object').click(function(e)
  {
    e.preventDefault();
    if ($(this).hasClass('upload-object'))
    {
        $(this).parent().find('form').hide();
        $(this).before('<span class="uploading">Sending...</span>');
        $(this).hide();
        var button = $(this);
        var data = new FormData();
        data.append('file', $(this).parent().find('input[type=file]')[0].files[0]);
        $.ajax(
        {
          url: 'editobject.php?newFile=true&id=<?php echo $_GET['edit']; ?>&comment='+$($(this).parent().find('input[type=text]')).val(),
          type: 'POST',
          data: data,
          cache: false,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function(data)
          {
            if (data.fileId != -1)
              $(button).before('<p>'+data.fileName+'<a href="editobject.php?deleteFile='+data.fileId+'" class="delete-file"><span class="glyphicon glyphicon-remove"></span></a></p>')
            $(button).before('<div class="alert alert-success">Sent!</div>')
            $(button).html('<span class="glyphicon glyphicon-plus"></span>');
            $(button).show();
            $(button).removeClass('upload-object');
            $('.newFile-form').first().remove();
            $('.uploading').remove();
          },
          error: function(jqXHR, textStatus, errorThrown)
          {
            $(button).before('<div class="alert alert-danger">Error!</div>')
            $(button).html('<span class="glyphicon glyphicon-plus"></span>');
            $(button).show();
            $(button).removeClass('upload-object');
            $('.newFile-form').first().remove();
            $('.uploading').remove();
          }
        });
    }
    else
    {
      $(this).before($('#add-file').html());
      $(this).addClass('upload-object');
      $(this).html('Upload');
    }
  });

  // Handle the new file update
  $('.add-picture').click(function(e)
  {
    e.preventDefault();
    if ($(this).hasClass('upload-picture'))
    {
        $(this).parent().find('form').hide();
        $(this).before('<span class="uploading">Sending...</span>');
        $(this).hide();
        var button = $(this);
        var data = new FormData();
        data.append('file', $(this).parent().find('input[type=file]')[0].files[0]);
        $.ajax(
        {
          url: 'editobject.php?newPicture=true&id=<?php echo $_GET['edit']; ?>&comment='+$($(this).parent().find('input[type=text]')).val(),
          type: 'POST',
          data: data,
          cache: false,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function(data)
          {
            $(button).parent().parent().before('<div class="object-image col-sm-4"><a href="files/'+data.objectid+'/'+data.file+'"><img src="files/'+data.objectid+'/'+data.file+'" alt="Picture"></a><span>'+data.comment+' <button class="btn btn-danger delete-picture" picture="'+data.fileid+'"><span class="glyphicon glyphicon-remove"></span></button></span></div>');
            $(button).html('<span class="glyphicon glyphicon-plus"></span> Photo');
            $(button).show();
            $(button).removeClass('upload-picture');
            $('.new-picture-form').first().remove();
            $('.uploading').remove();
          },
          error: function(jqXHR, textStatus, errorThrown)
          {
            $(this).parent().parent().before('<div class="alert alert-danger">Error!</div>')
            $(button).html('<span class="glyphicon glyphicon-plus"></span> Photo');
            $(button).show();
            $(button).removeClass('upload-picture');
            $('.new-picture-form').first().remove();
            $('.uploading').remove();
          }
        });
    }
    else
    {
      $(this).after($('#add-picture').html());
      $(this).addClass('upload-picture');
      $(this).html('Upload');
    }
  });

  $('.add-video').click(function(e){
    e.preventDefault();
    if ($(this).hasClass('new-video'))
    {
        $(this).parent().find('form').hide();
        $(this).before('<span class="uploading">Sending...</span>');
        $(this).hide();
        var button = $(this);
        $.ajax(
        {
          url: 'editobject.php?newVideo=true&id=<?php echo $_GET['edit']; ?>&'+$('.new-video-form').first().serialize(),
          type: 'GET',
          cache: false,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function(data)
          {
            $(button).parent().parent().before('<div class="object-image col-sm-4"><iframe src="//www.youtube.com/embed/'+data.url+'" frameborder="0" allowfullscreen></iframe><span>'+data.comment+'<button class="btn btn-danger delete-video" video="'+data.videoid+'"><span class="glyphicon glyphicon-remove"></span></button></span></div>');
            $(this).html('<span class="glyphicon glyphicon-plus"></span> Video');
            $(button).show();
            $(this).removeClass('new-video');
            $('.new-video-form').first().remove();
            $('.uploading').remove();
          }
        });
    }
    else
    {
      $(this).after($('#add-video').html());
      $(this).addClass('new-video');
      $(this).html('Save');
    }
  });

</script>