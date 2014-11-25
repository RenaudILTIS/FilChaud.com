<div class="container row">
	<div class="col-md-12">
		<h2>Upload an object</h2>
		<form action="upload.php" method="post" id="infos">
			<hr>
			<h4>Informations</h4>
			<div class="input-group">
			  <span class="input-group-addon">Name</span>
			  <input name="name" type="text" class="form-control" placeholder="My super cool object">
			</div>
			<div class="input-group">
				<span class="input-group-addon">Category</span>
				<div class="btn-group" data-toggle="buttons">
					<?php
						foreach($categories as $category)
						{
							echo '<label class="btn btn-primary">';
	    					echo '<input type="radio" name="category" value="'.$category['id'].'"> '.$category['name'];
	    					echo '</label>';
						}
					?>
				</div>
			</div>
			<div class="input-group">
			  <span class="input-group-addon">Licence</span>
				<div class="btn-group" data-toggle="buttons">
					<?php
						foreach($licences as $licence)
						{
							echo '<label class="btn btn-primary">';
	    					echo '<input type="radio" name="licence" value="'.$licence['id'].'"> '.$licence['name'];
	    					echo '</label>';
						}
					?>
				</div>
			</div>
			<div class="input-group">
			  <span class="input-group-addon">Recommended raw material</span>
			  <input name="raw_material" type="text" class="form-control" placeholder="Super Duper foam 42">
			</div>
			<div class="input-group">
			  <span class="input-group-addon">Type of hot wire cutting machine to do this project</span>
				<div class="btn-group" data-toggle="buttons">
					<?php
						foreach($wires as $wire)
						{
							echo '<label class="btn btn-primary">';
	    					echo '<input type="radio" name="hotwire" value="'.$wire['id'].'"> '.$wire['name'];
	    					echo '</label>';
						}
					?>
				</div>
			</div>
			<div class="input-group">
			  <span class="input-group-addon">Description</span>
				<textarea name="description" class="form-control form-area" rows="3"></textarea>
			</div>
			<hr>
			<h4>Videos</h4>
			<ul id="videos" class="list-unstyled">
				<li>
					<button class="btn btn-success add-element" data-element="video-element"><span class="glyphicon glyphicon-plus"></span>  Link Video</button>
				</li>
			</ul>
		</form>
        <hr>
		<form action="upload.php" method="post" id="files">
			<h4>Files</h4>
			<ul id="files" class="list-unstyled">
				<li>
					<button class="btn btn-success add-element" data-element="file-element"><span class="glyphicon glyphicon-plus"></span>  Project File</button>
				</li>
			</ul>
		</form>
        <hr>
		<form action="upload.php" method="post" id="pictures">
			<h4>Pictures - add <strong>at first picture presentation</strong> of the project</h4>
			<ul id="pictures" class="list-unstyled">
				<li>
					<button class="btn btn-success add-element" data-element="picture-element"><span class="glyphicon glyphicon-plus"></span>  Picture / Photo</button>
				</li>
			</ul>
		</form>
        <hr>
		<div class="checkbox">
		<label>
			<input type="checkbox" name="tos" id="tos" value="accepted" required>
			I agree to the <a href="cms.php?id=1" target="about:blank">terms of service and privacy policy</a>
		</label>
		</div>
		<hr>
		<button class="btn btn-primary" id="submit">Submit</button>
	</div>
</div>

<!-- HIDDEN ELEMENTS TO ADD -->
<div id="progress-element" style="display: none;">
	<div class="progress progress-striped active">
	  <div class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
	    <span>0% Complete</span>
	  </div>
	</div>
</div>

<ul id="video-element" style="display: none;">
	<li>
		<div class="input-group">
			<span class="input-group-addon">Youtube URL</span>
			<input name="videos[]" type="text" class="form-control" placeholder="http://youtube.com/12345678">
			<span class="input-group-addon">Caption</span>
			<input name="descriptions[]" type="text" class="form-control" placeholder="My great video">
			<span class="input-group-btn">
				<button class="btn btn-danger delete-element" type="button"><span class="glyphicon glyphicon-minus"></span></button>
			</span>
		</div>
	</li>
</ul>

<ul id="file-element" style="display: none;">
	<li>
		<div class="input-group">
			<span class="input-group-addon">File</span>
			<input type="file" class="form-control" data-filename-placement="inside">

			
			<span class="input-group-btn">
				<button class="btn btn-danger delete-element" type="button"><span class="glyphicon glyphicon-minus"></span></button>
			</span>
		</div>
	</li>
</ul>

<ul id="picture-element" style="display: none;">
	<li>
		<div class="input-group">
			<span class="input-group-addon">Picture</span>
			<input type="file" class="form-control" data-filename-placement="inside">
			<span class="input-group-addon">Comment</span>
			<input type="text" class="form-control" placeholder="The Finished project">
			<span class="input-group-btn">
				<button class="btn btn-danger delete-element" type="button"><span class="glyphicon glyphicon-minus"></span></button>
			</span>
		</div>
	</li>
</ul>

<script type="text/javascript">

//To be removed for a custom-made thing
$('input[type=file]').bootstrapFileInput();

$('.add-element').click(function(e)
{
	$(this).parent().before($('#'+$(this).attr('data-element')).html());
	e.preventDefault();
});

//$('.delete-element').click(function(e)
$('body').delegate('.delete-element', 'click', function(e)
{
	// WTF parent('li') doesn't work here?
	$(this).parent().parent().parent().remove();
	e.preventDefault();
});

$('#submit').click(function(e)
{
    e.stopPropagation();
	e.preventDefault();

	if (!$('#tos').is(':checked'))
	{
		alert("Please accept our terms of service");
		return -1;
	}

	if (!$("input:text[name='name']").val())
	{
		alert('Please choose a name');
		return -1;
	}

	if (!$("input[name='category']:checked").val())
	{
		alert('Please select a category');
		return -1;
	}

	if (!$("input[name='licence']:checked").val())
	{
		alert('Please select a licence');
		return -1;
	}

	if (!$("input[name='hotwire']:checked").val())
	{
		alert('Please select a machine');
		return -1;
	}

	//Remove add buttons
	$('.add-element').remove();
	$('#tos').parent().parent().hide();
	$('#submit').hide();

	var object_id = 0;
    $.ajax(
    {
        type: 'POST',
        url: 'upload.php?newObject=true',
        data: $("#infos").serialize(),
        success: function(data)
        {
 			object_id = data;

 			//Remove the entire block and start uploading the files...
 			$('#infos').html('<div class="alert alert-success">Informations sent! <a target="_blank" href="object.php?id='+object_id+'"">View your object</a></div>');

 			// Upload files
			var upload_id = 1;
			var success_files = 0;
			$('#files input[type=file]').each(function(key, value)
			{
				var current_upload = upload_id;
				$(this).parent().parent().parent().html('<div id="upload_'+current_upload+'" class="current-upload">'+$('#progress-element').html()+'</div>');
				var data = new FormData();
				data.append('file', $(this)[0].files[0]);
				$.ajax(
				{
				    xhr: function()
				    {
						var xhr = new window.XMLHttpRequest();
						xhr.upload.addEventListener("progress", function(evt)
						{
							if (evt.lengthComputable)
							{
								var percentComplete = (evt.loaded / evt.total)*100;
								$('#upload_'+current_upload+' .progress-bar').first().attr('aria-valuenow', percentComplete);
								$('#upload_'+current_upload+' .progress-bar').first().css('width', percentComplete+'%');
								$('#upload_'+current_upload+' span').first().html('Uploading...');
							}
							else
								console.log('WTF?');
						}, false);
						return xhr;
				    },
					url: 'upload.php?newFile=true&id='+object_id+'&comment='+$($(this).parent().parent().find('input[type=text]')).val(),
					type: 'POST',
					data: data,
					cache: false,
					dataType: 'json',
					processData: false,
					contentType: false,
					success: function(data, textStatus, jqXHR)
					{
						$('#upload_'+current_upload+' .progress-bar').attr('aria-valuenow', 100);
						$('#upload_'+current_upload+' .progress-bar').css('width', '100%');
						$('#upload_'+current_upload+' .progress').removeClass('active');
						$('#upload_'+current_upload+' .progress').removeClass('progress-striped');
						$('#upload_'+current_upload+' .progress-bar').addClass('progress-bar-success');
						$('#upload_'+current_upload+' span').html('Sent');
						$('#upload_'+current_upload).removeClass('current-upload');
					},
					error: function(jqXHR, textStatus, errorThrown)
					{
						$('#upload_'+current_upload+' .progress-bar').attr('aria-valuenow', 100);
						$('#upload_'+current_upload+' .progress-bar').css('width', '100%');
						$('#upload_'+current_upload+' .progress').removeClass('active');
						$('#upload_'+current_upload+' .progress').removeClass('progress-striped');
						$('#upload_'+current_upload+' .progress-bar').addClass('progress-bar-danger');
						$('#upload_'+current_upload+' span').html('Failed!');
						$('#upload_'+current_upload).removeClass('current-upload');
					}
				});
				upload_id++;
			});


			// Upload Pictures
			var i = 0;
			upload_id = 1;
			$('#pictures input[type=file]').each(function(key, value)
			{
				var current_upload = upload_id;
				$(this).parent().parent().parent().html('<div id="upload_'+current_upload+'" class="current-upload">'+$('#progress-element').html()+'</div>');
				var data = new FormData();
				console.log($(this));
				data.append('file', $(this)[0].files[0]);
				$.ajax(
				{
				    xhr: function()
				    {
						var xhr = new window.XMLHttpRequest();
						xhr.upload.addEventListener("progress", function(evt)
						{
							if (evt.lengthComputable)
							{
								var percentComplete = (evt.loaded / evt.total)*100;
								$('#upload_'+current_upload+' .progress-bar').first().attr('aria-valuenow', percentComplete);
								$('#upload_'+current_upload+' .progress-bar').first().css('width', percentComplete+'%');
								$('#upload_'+current_upload+' span').first().html('Uploading...');
							}
							else
								console.log('WTF?');
						}, false);
						return xhr;
				    },
					url: 'upload.php?newPicture=true&id='+object_id+'&i='+i+'&comment='+$($(this).parent().parent().find('input[type=text]')).val(),
					type: 'POST',
					data: data,
					cache: false,
					dataType: 'json',
					processData: false,
					contentType: false,
					success: function(data, textStatus, jqXHR)
					{
						$('#upload_'+current_upload+' .progress-bar').attr('aria-valuenow', 100);
						$('#upload_'+current_upload+' .progress-bar').css('width', '100%');
						$('#upload_'+current_upload+' .progress').removeClass('active');
						$('#upload_'+current_upload+' .progress').removeClass('progress-striped');
						$('#upload_'+current_upload+' .progress-bar').addClass('progress-bar-success');
						$('#upload_'+current_upload+' span').html('Sent');
						$('#upload_'+current_upload).removeClass('current-upload');
					},
					error: function(jqXHR, textStatus, errorThrown)
					{
						$('#upload_'+current_upload+' .progress-bar').attr('aria-valuenow', 100);
						$('#upload_'+current_upload+' .progress-bar').css('width', '100%');
						$('#upload_'+current_upload+' .progress').removeClass('active');
						$('#upload_'+current_upload+' .progress').removeClass('progress-striped');
						$('#upload_'+current_upload+' .progress-bar').addClass('progress-bar-danger');
						$('#upload_'+current_upload+' span').html('Failed!');
						$('#upload_'+current_upload).removeClass('current-upload');
					}
				});
				upload_id++;
				i++;
			});
        }
    });
	e.preventDefault();
});
</script>