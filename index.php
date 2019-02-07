<?php
	
	require_once 'core/init.php';
	
	Helper::getHeader('Algebra','main-header');
	
?>	
	<div class="row">
		<div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
			<div class="jumbotron">
				<div class="container">
					<h1><?php 
					echo Config::get('app')['name']; 
					?></h1>
					<p>Lorem ipsum dolor sit amet!</p>
					
					<p>
						<a class="btn btn-primary btn-lg" href="login.php" role="button">Sign In</a>
						or
						<a class="btn btn-primary btn-lg" href="register.php" role="button">Create an account</a> 
					</p>
				</div>
			</div>
		</div>
	</div>
<?php
	
	echo '<pre>';
	print_r(Config::get('session'));
	echo '</pre>';
	
	Helper::getFooter('footer');
	
?>	