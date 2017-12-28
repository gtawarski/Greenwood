<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--GENERAL CLIENT LISTER-->
<div class="row ng-hide" ng-hide="loading || userDetail || userNew" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="filter_clientName" class="control-label col-xs-12 col-sm-2">Name</label>
					<div class="col-xs-12 col-sm-10">
						<div class="input-group">
							<input type="text" ng-model="filterNameSearch" class="form-control" placeholder="Search for user named..." ng-enter="currentPage=1;get_users()">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" ng-click="currentPage=1;get_users()">Search</button>
							</span>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row ng-hide" ng-hide="loading || userDetail || userNew" ng-cloak>
	<div class="col-xs-12">
		<div class="row">
			<div class="well">
				<div class="text-center">
					<button type="button" class="btn btn-info" ng-click="get_userDetail(null)">
						<span class="fa fa fa-users"></spin> Add New User
					</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="well">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th class="col-sm-2">First Name</th>
							<th class="col-sm-2">Last Name</th>
							<th class="col-sm-3">Email Address</th>
							<th class="col-sm-1">Status</th>
							<th class="col-sm-1">Access</th>
							<th class="col-sm-1">Client</th>
							<th class="col-sm-1">Broker</th>
							<th class="col-sm-1">Details</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="user in users track by user.users_id">
							<td>{{user.firstname}}</td>
							<td>{{user.lastname}}</td>
							<td>{{user.email}}</td>
							<td>{{user.status}}</td>
							<td>{{user.access}}</td>
							<td>{{user.client_name}}</td>
							<td>{{user.broker_name}}</td>
							<td>
								<button type="button" class="btn btn-info" ng-click="get_userDetail(user)">
									Edit
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="text-center" ng-hide="loading || userDetail || userNew" ng-cloak>
	<div class="well">
		<pagination total-items="recordsItemCount" boundary-links="true" items-per-page="50" max-size="7" ng-model="currentPage" ng-change="get_users()" num-pages="numPages"></pagination>
		<div>Page: {{currentPage}} / {{numPages}}</div>
	</div>
</div>
<!--END GENERAL USER LISTER-->

<!--USER DETAIL-->
<div class="row" ng-show="!loading && (userDetail || userNew)" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<h1><span ng-if="userDetail">Update a</span><span ng-if="userNew">New</span> User</h1>
			<div ng-if="errors.length > 0" class="alert alert-danger" role="alert">
				<p ng-repeat="error in errors">{{error}}</p>
			</div>
			<form name="userDetailForm" class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-sm-5 control-label">First Name</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" ng-model="userDetail.users_firstname" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">Last Name</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" ng-model="userDetail.users_lastname" />
					</div>	
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">E-mail</label>
					<div class="col-sm-6">
						<input type="email" class="form-control"  ng-model="userDetail.users_email" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">Password</label>
					<div class="col-sm-6">
						<input type="{{passwordType}}" class="form-control"  ng-model="userDetail.users_password" ng-if="userDetail.users_id != null" />
						<p ng-if="userDetail.users_id == null" class="form-control-static">Password will be generated and emailed to user</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-5 col-sm-6">
						<div class="checkbox">
							<label>
								<input type="checkbox" ng-model="showPassword" ng-change="show_password()" /> <span ng-if="!showPassword">Show</span><span ng-if="showPassword">Hide</span> Password
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">Access Level</label>
					<div class="col-sm-6">
						<?php if($user['accessConfigs_id'] == 1): ?>
						<div class="radio">
							<label>
								<input type="radio" ng-model="userDetail.accessConfigs_id" value="1" /> Root
							</label>
						</div>
						<?php endif; ?>
						<div class="radio">
							<label>
								<input type="radio" ng-model="userDetail.accessConfigs_id" value="9" /> Admin
							</label>
						</div>
						<div class="radio">	
							<label>
								<input type="radio" ng-model="userDetail.accessConfigs_id" value="10" /> All Access
							</label>
						</div>
						<!-- <div class="radio">	
							<label>
								<input type="radio" ng-model="userDetail.accessConfigs_id" value="11" /> Limited Access
							</label>
						</div> -->
					</div>
				</div>
				<div class="form-group" ng-hide="userDetail.accessConfigs_id == 1 || userDetail.accessConfigs_id == 9 || userDetail.accessConfigs_id == 10">
					<label class="col-sm-5 control-label">Broker</label>
					<div class="col-sm-6">
						<select class="form-control"
								ng-model="userDetail.brokers_id"
								ng-options="k as v for (k,v) in brokers"
								ng-disabled="userDetail.clients_id > 0"
							>
						</select>
					</div>
				</div>
				<div class="form-group" ng-hide="userDetail.accessConfigs_id == 1 || userDetail.accessConfigs_id == 9 || userDetail.accessConfigs_id == 10">
					<label class="col-sm-5 control-label">Client</label>
					<div class="col-sm-6">
						<select class="form-control"
								ng-model="userDetail.clients_id"
								ng-options="k as v for (k,v) in clients"
								ng-disabled="userDetail.brokers_id > 0"
							>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<button ng-hide="userDetail.users_id == 0" class="btn btn-success" type="button" ng-click="put_userNew();">Save <span class="glyphicon glyphicon-ok-circle"></span></button>
						<button ng-hide="userDetail.users_id != 0" class="btn btn-success" type="button" ng-click="patch_userDetail();">Update <span class="glyphicon glyphicon-ok-circle"></span></button>
						<button class="btn btn-warning" type="button" ng-click="get_users();">Close <span class="glyphicon glyphicon-remove-circle"></span></button>
						<button class="btn btn-danger" type="button" ng-click="delete_userDetail();">Delete <span class="glyphicon glyphicon-trash"></span></button>
					</div>
				</div>
			</form>
			<hr />
		</div>
	</div>
</div>
<!--END USER DETAIL-->

<?php
/* End of file index.php */
/* Location: ./application/views/users/index.php */