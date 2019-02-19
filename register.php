<?php
	
	require_once 'core/init.php';
	
	Helper::getHeader('Algebra Contacts','main-header');
	
	$user = new User();
	
	/*echo $salt = Hash::salt(32);
	echo '<br/>';
	echo $password = Hash::make(Input::get('password',$salt));*/
	$validation = new Validation();
	
	if(Input::exists()) {
		if (Token::factory()->check(Input::get('token'))) {
			$validate = $validation->check([
				'name' => [
					'required' => true,
					'min' => 2, 
					'max' => 25
					],
				'username' => [
					'required' => true,
					'min' => 2, 
					'max' => 25,
					'unique' => 'users'
					],
				'password' => [
					'required' => true,
					'min' => 3,
					'password_condition' => false //zadaca veliko i malo slovo i broj
					],
				'confirm_password' => [
					'required' => true,
					'matches' => 'password' 
					]
				]);
			}		
			if ($validate->passed()) {
				$salt = Hash::salt(32);
				$password = Hash::make(Input::get('password'),$salt);
				
				try {
					$user->create([
						'name' => Input::get('name'),
						'username' => Input::get('username'),
						'password' => $password,
						'salt' => $salt,
						'role_id' => 1
						]);
					}
				catch (Exception $e) {
					Session::flash('danger',$e->getMessage());
					Redirect::to('register');
					return false;
					}
					
				Session::flash('success',"You have registered successfuly");
				Redirect::to('login');
				}		
		}
?>	

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Create an account</h3>
			</div>
			<div class="panel-body">
				<form method="POST">
					<input type="hidden" name="token" value="<?php echo Token::factory()::generate(); ?>">
					<div class="form-group <?php echo($validation->hasError('name')) ? 'has-error' : ''; ?>">
						<label class="control-label" for="name">Name*</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?php echo Input::get('name')  ?>">
						<?php echo ($validation->hasError('name')) ? '<p class="text-danger">' . $validation->hasError('name') . '</p>' : ''; 
						?>
					</div>
					<div class="form-group <?php echo($validation->hasError('username')) ? 'has-error' : ''; ?>">
						<label class="control-label" for="name">Username*</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" value="<?php echo Input::get('username')  ?>">
						<?php echo ($validation->hasError('username')) ? '<p class="text-danger">' . $validation->hasError('username') . '</p>' : '';
						?>
					</div>
					<div class="form-group <?php echo($validation->hasError('password')) ? 'has-error' : ''; ?>">
						<label class="control-label" for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Choose a password">
						<?php echo ($validation->hasError('password')) ? '<p class="text-danger">' . $validation->hasError('password') . '</p>' : '';
						?>
					</div>
					<div class="form-group <?php echo($validation->hasError('confirm_password')) ? 'has-error' : ''; ?>">
						<label class="control-label" for="confirm_password">Confirm Password</label>
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter your password again">
						<?php echo ($validation->hasError('confirm_password')) ? '<p class="text-danger">' . $validation->hasError('confirm_password') . '</p>' : '';
						?>
					</div>
					<button type="submit" class="btn btn-primary">Create an account</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
	/*
	echo '<pre>';
	print_r($_SESSION);
	print_r($_POST);
	echo '</pre>';*/
	
	Helper::getFooter('footer');
	
?>