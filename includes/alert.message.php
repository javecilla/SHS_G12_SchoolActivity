<?php
	if(isset($_SESSION['message']))	:
?>
	<div class="alert alert-success alert-dismissible fade show">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong><?= $_SESSION['message']; ?></strong>
	</div>

<?php 
	unset($_SESSION['message']);
	endif;
?>