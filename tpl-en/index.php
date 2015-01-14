<?php if (isset($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
<div class="jumbotron row">
	<div class="col-lg-5">
	<!--	<iframe width="400" height="225" src="//www.youtube.com/embed/THyjqlgmbpU" frameborder="0" allowfullscreen></iframe> -->
		<img src="img/intro.jpg" class="adapt" alt="Intro image">
	</div>
	<div class="col-lg-7">
		<h2>HotWireProjects.com</h2>
		<p>The place to find and share polystyrene<br />hot-wire-cutted projects for the MiniCut2d.<br /><br />Model-making, design, decoration,<br />toys, logos, serial cutting... be creative!</p>
	</div>
</div>

<div class="row" id="objects">
	<?php
		$i = 0;
		echo '<div class="row">';
		foreach($objects as $object)
		{
			echo '<div class="col-md-3 object">';
			echo '<a href="object.php?id='.$object['id'].'"><img src="'.((file_exists('files/'.$object['id'].'/image.jpg'))?'files/'.$object['id'].'/image.jpg':'img/nofile.png').'" class="center adapt" alt="Intro image"></a>';
			echo '<a href="object.php?id='.$object['id'].'"><h2>'.$object['name'].'</h2></a>';
			echo '<p>'.substr($object['description'],0,150).'</p>';
			echo '<p><a class="btn btn-default btn-object" href="object.php?id='.$object['id'].'" role="button">View details &raquo;</a></p>';
			echo '</div>';

			$i++;

			if (!($i % 4))
			{
				echo'</div>	';
				echo '<div class="row">';
			}
		}
		if (($i)%4)
			echo'</div>	';

		echo '<ul class="pagination">';
		echo '<li '.(($pageNum <= 0)?'class="disabled"':'').'><a href="index.php?page='.(($pageNum <= 0)?'0':$pageNum-1).'#objects">Previous</a></li>';
		echo '<li class="active"><a href="#objects">'.(($pageNum<1)?'1':$pageNum+1).' / '.ceil($nbobjects/OBJECTS_PER_PAGE).'<span class="sr-only">(current)</span></a></li>';
		if($pageNum+1==ceil($nbobjects/OBJECTS_PER_PAGE))
			echo '<li class="disabled"><a href>Next</a></li>';
		else
			echo '<li><a href="index.php?page='.((count($objects) < OBJECTS_PER_PAGE)?$pageNum:(($pageNum <= 0)?1:$pageNum+1)).'#objects">Next</a></li>';
		echo '</ul>  ';
		echo '<ul class="pagination">';
		echo '<li><a href="index.php?page='.(($pageNum <= 0)?'0':$pageNum).'"><span class="glyphicon glyphicon-chevron-up"></span></a></li>';
	 	echo '</ul>';
	?>
</div>