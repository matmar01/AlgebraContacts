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
	
	$db = DB::getInstance();
	//$rez = $db->query('SELECT * FROM users WHERE id = ? AND username = ?;',array(1,'alex'));
	
	$get = $db->get('name','users',['id','=',1]);
	
	//$delete = $db->delete('users',['id','=',1]);
	
	$find = $db->find(3,'users');
	
	/*echo '<pre>';
	var_dump($rez);
	echo '</pre>';*/
	
	/*echo '<pre>';
	var_dump($find);
	echo '</pre>';*/
	
	/*echo '<pre>';
	var_dump($delete);
	echo '</pre>';*/
	
	/*echo '<pre>';
	print_r(Config::get('app'));
	echo '</pre>';
	*/
	
	/*$update = $db->update('users',4,['username' => 'marina',
	'name' => 'Ivan']);
	
	echo '<pre>';
	var_dump($update);
	echo '</pre>';*/
	
	$insert = $db->insert('users',
	['name' => 'Iva',
	'username' => 'iva',
	'password' => 'q12432543',
	'salt' => '5468354',
	'role_id' => '1']);
	
	echo '<pre>';
	var_dump($insert);
	echo '</pre>';
	
	Helper::getFooter('footer');
	
?>	