<?php foreach($scripts as $script):
		if (is_readable($script)):
			require $script;

		endif;
	endforeach; 
?>