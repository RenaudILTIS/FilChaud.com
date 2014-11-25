<div class="container row">
	<h1><?php echo $title; ?></h1>
	<?php
		$i = 0;

		if (!empty($objects))
		{
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

			if (getVar('category'))
				$url = 'objects.php?category='.getVar('category').'&page=';
			else if (getVar('user'))
				$url = 'objects.php?user='.getVar('user').'&page=';
			else if (getVar('search'))
				$url = 'objects.php?search='.getVar('user').'&page=';


			echo '<ul class="pagination">';
			echo '<li '.(($pageNum <= 1)?'class="disabled"':'').'><a href="'.$url.(($pageNum <= 1)?'1':$pageNum-1).'">Previous</a></li>';
		 	if ($pageNum >= 2)
		 		echo '<li><a href="'.$url.($pageNum-1).'">'.($pageNum-1).'</a></li>';
			echo '<li class="active"><a href="#">'.(($pageNum)?$pageNum:'1').' <span class="sr-only">(current)</span></a></li>';
		 	if (count($objects) == OBJECTS_PER_PAGE)
		 		echo '<li><a href="'.$url.(($pageNum >= 2)?$pageNum+1:2).'">'.(($pageNum >= 2)?$pageNum+1:2).'</a></li>';
			echo '<li '.((count($objects) < OBJECTS_PER_PAGE)?'class="disabled"':'').'><a href="'.$url.((count($objects) < OBJECTS_PER_PAGE)?$pageNum:(($pageNum >= 2)?$pageNum+1:2)).'">Next</a></li>';
			echo '</ul>';
		}
		else
			echo '<h1>No objects found!</h1>';
	?>
</div>
