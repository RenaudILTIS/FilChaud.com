<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Activate navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
        	<a class="navbar-brand" href="index.php"><img src="img/logo-en.png"></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<!--li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span></a></li-->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php
							foreach ($categories as $category)
								echo '<li><a href="objects.php?category='.$category['id'].'">'.$category['name'].'</a></li>';
						?>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Infos <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php
							foreach ($cmsPages as $cmsPage)
								echo '<li><a href="cms.php?id='.$cmsPage['id'].'">'.$cmsPage['name'].'</a></li>';
						?>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Language <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?lang=fr">Français</a></li>
						<li><a href="index.php?lang=en">English</a></li>
					</ul>
				</li>
			</ul>
			<?php if (!isLogged() || $_GET['action'] == 'logout') { ?>
				<div class="navbar-form navbar-right btn-group">
					<button class="btn btn-primary btn-signin">Sign in</button>
					<button class="btn btn-success btn-signup" data-toggle="modal" data-target=".bs-example-modal-sm">Sign up</button>
				</div>
				<form action="signin.php" method="post" class="navbar-form navbar-right frm-signin" style="display: none;" role="form">
					<div class="form-group">
						<input type="text" placeholder="Login" name="username" class="form-control">
					</div>
					<div class="form-group">
						<input type="password" placeholder="Password" name="password" class="form-control">
					</div>
					<button type="submit" class="btn btn-primary">Ok</button>
					
					&nbsp;<a href="#reminder" class="tooltip-link" data-placement="bottom" role="button" data-toggle="modal" rel="tooltip" data-original-title="Password forgotten"><span class="glyphicon glyphicon-exclamation-sign"></span></a>
					<!-- <button class="btn btn-primary btn-reminder" data-toggle="modal" data-target=".bs-reminder-modal-sm"><span class="glyphicon glyphicon-exclamation-sign"></span></button> -->
				</form>
			<?php } else { ?>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="objects.php?user=<?php echo $_SESSION['id']; ?>" class="tooltip-link" data-toggle="tooltip" data-placement="bottom" title="My objects"><span class="glyphicon glyphicon-folder-open"></span></a></li>
					<li><a href="upload.php" class="tooltip-link" data-toggle="tooltip" data-placement="bottom" title="Upload"><span class="glyphicon glyphicon-upload"></span></a></li>
					<li><a href="profil.php" class="tooltip-link" data-toggle="tooltip" data-placement="bottom" title="Settings"><span class="glyphicon glyphicon-wrench"></span></a></li>
					<li><a href="index.php?action=logout" class="tooltip-link" data-toggle="tooltip" data-placement="bottom" title="Log out"><span class="glyphicon glyphicon-log-out"></span></a></li>
				</ul>
			<?php } ?>
			<form class="navbar-form navbar-right searchform" action="objects.php" method="get">
				<input type="text" name="search" class="form-control" placeholder="Search...">
			</form>
		</div>
	</div>
</div>

<?php if (!isLogged() || $_GET['action'] == 'logout') { ?>
	<div class="modal modal-vertical-center fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	    	<h3 class="modal-title">Sign up</h3>
			<form action="signup.php" method="post" class="form-signup">
				<input type="text" class="form-control" name="username" placeholder="Username" style="margin-bottom: 15px;" required>
				<input type="text" class="form-control" name="email" placeholder="Email" style="margin-bottom: 15px;" required>
				<input type="Password" class="form-control" name="pass1" placeholder="Password" style="margin-bottom: 15px;" required>
				<input type="Password" class="form-control" name="pass2" placeholder="Confirm password" style="margin-bottom: 15px;" required>
				<button type="submit" class="btn btn-success btn-signform" data-toggle="dropdown" style="clear: left; width: 100%; height: 32px; font-size: 13px; margin-bottom: 15px;">Ok</button>
			</form>
	    </div>
	  </div>
	</div>
	<div class="modal modal-vertical-center fade bs-reminder-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
        	<h3 class="modal-title">Password Reset</h3>
    		<form action="reminder.php" method="post" class="form-reminder">
    			<input type="text" class="form-control" name="email" placeholder="Email" style="margin-bottom: 15px;" required>
    			<button type="submit" class="btn btn-success btn-reminderform" data-toggle="dropdown" style="clear: left; width: 100%; height: 32px; font-size: 13px; margin-bottom: 15px;">Ok</button>
    		</form>
        </div>
      </div>
    </div>
<?php } ?>

<script type="text/javascript">
$('.btn-signin').click(function(e)
{
	$('.btn-signin').hide();
	$('.btn-signup').hide();
	$('.searchform').remove();
	$('.frm-signin').show();
	e.preventDefault();
});

$('.btn-signform').click(function(e)
{
	$('.form-signup').submit();
	e.preventDefault();
});

$('.btn-reminder').click(function(e)
{
    //$('.btn-reminder').hide();
    $('.btn-signup').hide();
    $('.btn-signin').hide();
    $('.searchform').remove();
    $('.form-reminder').show();
    e.preventDefault();
});

$('.btn-reminderform').click(function(e)
{
    $('.form-reminder').submit();
    e.preventDefault();
});

$('.tooltip-link').tooltip();
</script>