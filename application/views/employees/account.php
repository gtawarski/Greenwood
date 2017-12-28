<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--ACCOUNT EMPLOYEE INTERFACE-->
<div class="row" ng-show="!loading && users" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<div class="row">
				<div class="col-xs-12">
					<h1>Employee Management - Greenwood Group</h1>
				</div>
			</div>
			<div class="row" ng-hide="user">
				<div class="col-xs-12">
					<button class="btn btn-success" type="button" ng-click="get_user(null);">Add New User <span class="glyphicon glyphicon-ok-circle"></span></button>
				</div>
			</div>
			<div class="row" ng-hide="user">
				<div class="col-sm-12 col-md-4" ng-repeat="user in users.records track by user.users_id">
					<div class="well">
						<p>{{user.users_firstname}} {{user.users_lastname}}</p>
						<p><small>{{user.users_email}}</small> <button type="button" class="btn btn-primary btn-xs" ng-click="put_userInvitationRequest(user);" ng-hide="user.users_isActive == 1">Resend Invitation</button></p>
						<p><small>{{user.accessConfigs_name}}</small></p>
						<button type="button" class="btn btn-warning" ng-click="get_user(user);">Edit <span class="glyphicon glyphicon-cog"></span></button>
						<button type="button" class="btn btn-danger" ng-click="delete_user(user);">Delete <span class="glyphicon glyphicon-trash"></span></button>
					</div>
				</div>
			</div>

			<div class="row" ng-show="user">
				<div class="col-sm-12 col-md-12">
					<form role="form">
						<div class="form-group">
							<label>User Type</label>
							<label class="radio-inline<?php echo($user['accessConfigs_id'] > 1?' ng-hide':''); ?>">
								<input type="radio" ng-model="user.accessConfigs_id" value="1"> System Root
							</label>
							<label class="radio-inline">
								<input type="radio" ng-model="user.accessConfigs_id" value="2"> Owner
							</label>
							<label class="radio-inline">
								<input type="radio" ng-model="user.accessConfigs_id" value="3"> Manager
							</label>
							<label class="radio-inline">
								<input type="radio" ng-model="user.accessConfigs_id" value="4"> User
							</label>
						</div>
						<div class="form-group">
							<label>Email Address</label>
							<input type="text" class="form-control" ng-model="user.users_email" placeholder="Enter email">
						</div>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" ng-model="user.users_firstname" placeholder="Enter first name">
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" ng-model="user.users_lastname" placeholder="Enter last name">
						</div>
						<div class="row">
							<div class="col-xs-12">
								<button class="btn btn-success" type="button" ng-click="put_user()">Save <span class="glyphicon glyphicon-ok-circle"></span></button>
								<button class="btn btn-danger" type="button" ng-click="cancel_user()">Cancel <span class="glyphicon glyphicon-ban-circle"></span></button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
<!--END CLIENT USERS-->
<?php
/* End of file index.php */
/* Location: ./application/views/employees/account.php */