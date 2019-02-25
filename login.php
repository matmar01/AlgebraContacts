<?php
	/*
	 To je od prije
	require_once 'core/init.php';
	
	Helper::getHeader('Algebra Contacts','main-header');
	
	$user = new User();
	
	require 'notifications.php';
	
	//Redirect::to(404);
	//samo primjer
	
	$validation = new Validation();
	
	if(Input::exists()) {
		if (Token::factory()->check(Input::get('token'))) {
			$validate = $validation->check([
				'username' => [
					'required' => true,
					'min' => 2, 
					'max' => 25,
					'exists' => 'users'
					],
				'password' => [
					'required' => true,
					'min' => 3,
					'password_condition' => false
					]
				]);
			}	
		else {
			$validate = NULL;
			}	
		if (isset($validate)) {	
			if ($validate->passed()) {
				$result = DB::getInstance()->get('salt','users',['username','=',Input::get('username')])->getResults();
				$salt = '';
				foreach ($result as $keys => $values) {
					foreach ($values as $key => $value) {
						if ($key == 'salt') {
							$salt = $value;
							}
						}
					}
				$password = Hash::make(Input::get('password'),$salt);		
				try {
					Session::put('username',Input::get('username'));
					$user->login(Input::get('username'),$password);
					}
				catch (Exception $e) {
					Session::flash('danger',$e->getMessage());
					Redirect::to('login');
					return false;
					}
				Session::put('username',Input::get('username'));
				Session::flash('success',"You have logged in as " . "<b>" . Session::get('username') . "</b>" .  " successfuly");
				Redirect::to('dashboard');
				}
			}		
		}
	
	Novi dio_
	
	*/	
	/*	
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	*/
	
	require_once 'core/init.php';
	
	$user = new User();
	
	if ($user->check()) {
		
		Redirect::to('dashboard');
		
		}
	
	$validation = new Validation();
	if (Input::exists()) {
		if (Token::factory()->check(Input::get('token'))) {
			$validation->check([
				'username' => [
					'required' => true
					],
				'password' => [
					'required' => true
					]
				]);
			}
		if ($validation->passed()) {		
			$username = Input::get('username');
			$password = Input::get('password');
			$remember = (bool)Input::get('remember');
			
			$login = $user->login($username,$password,$remember);
			echo '---- ' . $login . ' ----';
			if ($login) {
				Session::put('username',Input::get('username'));
				Session::flash('success',"You have logged in as <b>" . Session::get('username') . "</b> successfuly");
				Session::delete('username');
				Redirect::to('dashboard');
				}
			else {
				Session::put('username',Input::get('username'));
				Session::flash('danger','Login failed,Please try again later.');
				Redirect::to('login');
				}	
			}
		else {
			Session::put('username',Input::get('username'));
			}	
		}
	
	Helper::getHeader('Algebra Contacts','main-header');
	
	require 'notifications.php';
	
?>

<div class="row">
    <div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Sign In</h3>
            </div>
            <div class="panel-body">
                <form method="post">
					<input type="hidden" name="token" value="<?php echo Token::factory()::generate(); ?>">
                    <div class="form-group <?php echo($validation->hasError('username')) ? 'has-error' : ''; ?>">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" autofocus value="<?php 
						echo (Session::exists('username') == true) ? Session::get('username') : ''; 
						Input::get('username');
						Session::delete('username');?>">
						<?php echo ($validation->hasError('username')) ? '<p class="text-danger">' . $validation->hasError('username') . '</p>' : '';
						?>
                    </div>
					<div class="form-group <?php echo($validation->hasError('password')) ? 'has-error' : ''; ?>">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
						<?php echo ($validation->hasError('password')) ? '<p class="text-danger">' . $validation->hasError('password') . '</p>' : '';
						?>
                    </div>
					<div class="checkbox">
						<label for="remember">
							<input type="checkbox" name="remember" value="true" id="remember">Remember me
						</label>
					</div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>
                    <p>If you don't have an account, please <a href="register.php">Register</a></p>
                </form>
            </div>
        </div>
    </div>
</div>





<?php

	Helper::getFooter('footer');
	
	//zadaca validacija token i logiranje
	//redirect na novu stranicu dashboard.php
?>