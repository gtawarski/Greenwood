<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--EMPLOYEE DETAIL-->
<p>Undergoing maintenance</p>
<!--<div class="row" ng-hide="loading" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<h1>Update My Account</h1>
			<p>You can update your account name using this form.</p>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-sm-4 control-label">Client Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control"  ng-model="clientDetail.name" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<button class="btn btn-success" type="button" ng-click="patch_clientDetail();">Update <span class="glyphicon glyphicon-ok-circle"></span></button>
						<button class="btn btn-danger" type="button" ng-click="get_clients();">Close <span class="glyphicon glyphicon-ban-circle"></span></button>
					</div>
				</div>
			</form>
			<hr />
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<h1>Client Managers</h1>
					<p><small>Managers can add other users to this client</small></p>
					<div class="list-group">
						<a href="#" class="list-group-item list-group-manager" ng-repeat="x in clientDetail.managers">
							<p>{{x.firstname}} {{x.lastname}}</p>
							<p><small>({{x.email}})</small></p>
							<button type="button" class="btn btn-danger" ng-click="delete_clientAccess(x.userAccess_id)">Remove Access <span class="glyphicon glyphicon-ban-circle"></span></button>
						</a>
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<h1>Client Users</h1>
					<p><small>Users can only access files available to the client</small></p>
					<div class="list-group">
						<a href="#" class="list-group-item  list-group-user" ng-repeat="x in clientDetail.users">
							<p>{{x.firstname}} {{x.lastname}}</p>
							<p><small>({{x.email}})</small></p>
							<button type="button" class="btn btn-danger" ng-click="delete_clientAccess(x.userAccess_id)">Remove Access <span class="glyphicon glyphicon-ban-circle"></span></button>
						</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<form role="form">
						<h2>Add a:</h2>
						<div class="form-group">
							<label class="radio-inline">
								<input type="radio" ng-model="user.accessConfigs_id" value="7"> Manager
							</label>
							<label class="radio-inline">
								<input type="radio" ng-model="user.accessConfigs_id" value="8"> User
							</label>
						</div>
						<div class="form-group">
							<label>Email address</label>
							<input type="text" class="form-control" ng-model="user.email" placeholder="Enter email">
						</div>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" ng-model="user.firstname" placeholder="Enter first name">
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" ng-model="user.lastname" placeholder="Enter last name">
						</div>
						<div class="row">
							<div class="col-xs-12">
								<button class="btn btn-success" type="button" ng-click="put_clientAccess()">Add <span class="glyphicon glyphicon-ok-circle"></span></button>
								<button class="btn btn-danger" type="button" ng-click="reset_clientAccess()">Reset <span class="glyphicon glyphicon-ban-circle"></span></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>-->
<!--END EMPLOYEE DETAIL-->
<?php
/* End of file client.php */
/* Location: ./application/views/employees/client.php */