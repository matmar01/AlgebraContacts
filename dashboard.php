<?php

	require_once 'core/init.php';
	
	$user = new User();
	
	if (!$user->check()) {
		
		Redirect::to('index');
		
		}
	
	Helper::getHeader('Algebra Contacts','main-header');
	
	require 'notifications.php';
	

?>
	
	<span style="margin: 0 auto;">
		<h1>Dashboard</h1>
	</span>	


	

<?php

	Helper::getFooter('footer');

?>