<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- LOGIN FORM -->
<div class="container text-center" ng-show="login" ng-hide="activate">
	<div class="row">
		<div class="col-md-offset-3 col-md-6 login-form">
			<h1 id="systemName">Welcome to <b>INTERCHANGE</b></h1>
			<hr />

			<div class="row ng-hide" ng-show="loginMessage">
				<div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0">
					<div class="alert alert-danger" role="alert">{{loginMessage}} <button type="button" class="close" ng-click="loginMessage = null;"><span aria-hidden="true">&times;</span></button></div>
				</div>
			</div>

			<form role="form" class="form-horizontal" method="post">
				<div class="form-group">
					<label class="sr-only" for="email">Email</label>
					<input type="email" class="form-control" ng-model="loginEmail" placeholder="Enter your Email" ng-enter="get_signIn()">
				</div>
				<div class="form-group">
					<label class="sr-only" for="password">Password</label>
					<input type="password" class="form-control" ng-model="loginPassword" placeholder="Enter your Password" ng-enter="get_signIn()">
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-6 margin-vertical">
						<button type="button" class="btn btn-success btn-lg width-100-percent" ng-click="get_signIn()">
							Sign In
						</button>
					</div>

					<div class="col-sm-12 col-md-6 margin-vertical">
						<button type="button" class="btn btn-danger btn-lg width-100-percent" ng-click="get_passwordReset()">
							Forgot Password
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- RESET PASSWORD FORM -->
<div class="container text-center" ng-show="reset">
	<div class="row">
		<div class="col-md-offset-3 col-md-6 login-form">
			<h1 id="systemName">Forgot your password?</h1>
			<p><strong>No problem!</strong>  Enter your email address to have a reset email sent to you!</p>
			<hr />	
			<div class="row ng-hide" ng-show="resetMessage">
				<div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0">
					<div class="alert alert-warning" role="alert">{{resetMessage}} <button type="button" class="close" ng-click="resetMessage = null"><span aria-hidden="true">&times;</span></button></div>
				</div>
			</div>
			<form role="form" class="form-horizontal">
				<div class="form-group">
					<label class="sr-only" for="email">Email</label>
					<input type="email" class="form-control" ng-model="resetEmail" placeholder="Enter your Email">
				</div>
				<div class="row">
					<div class="col-xs-6">
						<button type="button" class="btn btn-success btn-lg width-100-percent" ng-click="put_resetPassword()">
							Reset my password
						</button>
					</div>
					<div class="col-xs-6">
						<button type="button" class="btn btn-primary btn-lg width-100-percent" ng-click="get_login()">
							Back to login
						</button>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>

<!-- ACTIVATION FORM -->
<div class="container text-center" ng-show="activate" ng-init="<?php echo (isset($activate) && $activate == true?'activate=true;':''); ?>">
	<div class="row">
		<div class="col-md-offset-3 col-md-6 login-form">
			<h1 id="systemName">Activate your account!</h1>
			<hr />
			<div class="row ng-hide" ng-show="activationMessage">
				<div class="alert alert-danger" role="alert">{{activationMessage}} <button type="button" class="close" ng-click="activationMessage = null"><span aria-hidden="true">&times;</span></button></div>
			</div>
			<form role="form" class="form-horizontal">
				<div class="form-group">
					<label class="sr-only" for="email">Email</label>
					<input type="text" class="form-control" ng-model="activation.email" placeholder="Enter your Email">
				</div>
				<div class="form-group">
					<label class="sr-only" for="email">Registration Code</label>
					<input type="text" class="form-control" ng-model="activation.registration" placeholder="Enter your registration code">
				</div>
				<div class="form-group">
					<label class="sr-only" for="email">New Password</label>
					<input type="password" class="form-control" ng-model="activation.password" placeholder="Enter your new password">
				</div>
				<div class="form-group">
					<label class="sr-only" for="email">Confirm Password</label>
					<input type="password" class="form-control" ng-model="activation.confirmPassword" placeholder="Confirm your new password">
				</div>
				<div class="row">
					<div class="col-xs-12">
						<button type="button" class="btn btn-success btn-lg width-100-percent" ng-click="put_activation();" >
							Activate my account!
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
/* End of file index.php */
/* Location: ./application/views/system/index.php */
