<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--GENERAL CLIENT LISTER-->
<div class="row ng-hide" ng-hide="loading || clientDetail || clientNew || clientUsers" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="filter_clientName" class="control-label col-xs-12 col-sm-2">Name</label>
					<div class="col-xs-12 col-sm-10">
						<div class="input-group">
							<input type="text" ng-model="filterNameSearch" class="form-control" placeholder="Search for client named..." ng-enter="currentPage=1;get_clients()">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" ng-click="currentPage=1;get_clients()">Search</button>
							</span>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row" ng-hide="loading || clientDetail || clientNew || clientUsers" ng-cloak>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" ng-repeat="record in records track by record.clients_id">
		<div class="well fixed-height-250 text-center">
			<p tooltip-placement="bottom" tooltip="{{record.clients_name}}"><strong>{{record.clients_name | limitTo:25}}{{record.clients_name.length > 25?"...":""}}</strong></p>
			<p><img ng-src="/clients/get_clientLogo/{{record.clients_id}}/{{record.clients_datetime}}" height="100" width="100" /></p>
			<div class="text-center">
				<button type="button" class="btn btn-info" ng-click="get_clientDetail(record)">
					Edit
				</button>
				<button type="button" class="btn btn-success" ng-click="get_clientUsers(record)">
					Users
				</button>
				<button type="button" class="btn btn-warning" ng-click="get_clientFiles(record)">
					Files
				</button>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="well fixed-height-250">
			<h2 class="text-center">Add a new client</h2>
			<div class="text-center">
				<button type="button" class="btn btn-info" ng-click="get_clientDetail(null)">
					<span class="fa fa fa-users fa-5x"></spin>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="text-center" ng-hide="loading || clientDetail || clientNew || clientUsers" ng-cloak>
	<div class="well">
		<pagination total-items="recordsItemCount" boundary-links="true" items-per-page="12" max-size="7" ng-model="currentPage" ng-change="get_clients()" num-pages="numPages"></pagination>
		<div>Page: {{currentPage}} / {{numPages}}</div>
	</div>
</div>
<!--END GENERAL CLIENT LISTER-->

<!--CLIENT DETAIL-->
<div class="row" ng-show="!loading && clientDetail" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<h1>Update a Client</h1>
			<p>To update a client account, alter the account name.</p>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-sm-5 control-label">Client Name</label>
					<div class="col-sm-7">
						<input type="text" class="form-control"  ng-model="clientDetail.clients_name" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">Client Logo</label>
					<div class="col-sm-1">
						<button class="btn btn-primary" ng-file-select ng-model="clientDetailLogo" ng-multiple="multiple" ng-accept="'.jpg,.jpeg,.png'">Select File</button>
					</div>
					<div class="col-sm-6">
						{{clientDetailLogo[0].name}}
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5 control-label">
						<div><strong>Current Logo</strong></div>
						<button type="button" class="btn btn-primary" ng-click="delete_logo();">
							Clear Logo
						</button>
					</div>
					<div class="col-xs-7">
						<img ng-src="/clients/get_clientLogo/{{clientDetail.clients_id}}/{{clientDetail.clients_datetime}}" height="100" width="100" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<button class="btn btn-success" type="button" ng-click="patch_clientDetail();">Update <span class="glyphicon glyphicon-ok-circle"></span></button>
						<button class="btn btn-warning" type="button" ng-click="get_clients();">Close <span class="glyphicon glyphicon-remove-circle"></span></button>
						<button class="btn btn-danger" type="button" ng-click="delete_clientDetail();">Delete <span class="glyphicon glyphicon-trash"></span></button>
					</div>
				</div>
			</form>
			<hr />
		</div>
	</div>
</div>
<!--END CLIENT DETAIL-->

<!--CLIENT NEW-->
<div class="row" ng-show="!loading && clientNew" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<h1>Add a new Client</h1>
			<form class="form-horizontal" role="form">
				<div class="row" ng-show="clientNew.errorMessage">
					<div class="col-sm-12">
						<div class="alert alert-danger" role="alert">{{clientNew.errorMessage}}</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Client Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control"  ng-model="clientNew.clients_name" ng-change="clientNew.errorMessage=null" ng-enter="put_clientNew();" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<button class="btn btn-success" type="button" ng-click="put_clientNew();">Create <span class="glyphicon glyphicon-ok-circle"></span></button>
						<button class="btn btn-danger" type="button" ng-click="get_clients();">Cancel <span class="glyphicon glyphicon-ban-circle"></span></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!--END CLIENT NEW-->

<!--CLIENT USERS-->
<div class="row" ng-show="!loading && clientUsers" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<div class="row">
				<div class="col-xs-12">
					<h1>User Management - {{clientUsers.client.clients_name}}</h1>
				</div>
			</div>
			<div class="row" ng-hide="clientUser">
				<div class="col-xs-12">
					<button class="btn btn-warning" type="button" ng-click="get_clients();">Close <span class="glyphicon glyphicon-remove-circle"></span></button>
					<button class="btn btn-success" type="button" ng-click="get_clientUser(null);">Add New User <span class="glyphicon glyphicon-ok-circle"></span></button>
				</div>
			</div>
			<div class="row" ng-hide="clientUser">
				<div class="col-sm-12 col-md-4" ng-repeat="user in clientUsers.records track by user.users_id">
					<div class="well">
						<p>{{user.users_firstname}} {{user.users_lastname}}</p>
						<p><small>{{user.users_email}}</small></p>
						<p><small>{{user.accessConfigs_name}}</small></p>
						<button type="button" class="btn btn-warning" ng-click="get_clientUser(user);">Edit <span class="glyphicon glyphicon-cog"></span></button>
						<button type="button" class="btn btn-danger" ng-click="delete_clientUser(user);">Delete <span class="glyphicon glyphicon-trash"></span></button>
					</div>
				</div>
			</div>

			<div class="row" ng-show="clientUser">
				<div class="col-sm-12 col-md-12">
					<form role="form">
						<div class="form-group">
							<label>User Type</label>
							<label class="radio-inline">
								<input type="radio" ng-model="clientUser.accessConfigs_id" value="7"> Manager
							</label>
							<label class="radio-inline">
								<input type="radio" ng-model="clientUser.accessConfigs_id" value="8"> User
							</label>
						</div>
						<div class="form-group">
							<label>Email Address</label>
    						<input type="text" class="form-control" ng-model="clientUser.users_email" placeholder="Enter email">
						</div>
						<div class="form-group">
							<label>First Name</label>
    						<input type="text" class="form-control" ng-model="clientUser.users_firstname" placeholder="Enter first name">
						</div>
						<div class="form-group">
							<label>Last Name</label>
    						<input type="text" class="form-control" ng-model="clientUser.users_lastname" placeholder="Enter last name">
						</div>
						<div class="row">
							<div class="col-xs-12">
								<button class="btn btn-success" type="button" ng-click="put_clientUser()">Save <span class="glyphicon glyphicon-ok-circle"></span></button>
								<button class="btn btn-danger" type="button" ng-click="cancel_clientUser()">Cancel <span class="glyphicon glyphicon-ban-circle"></span></button>
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
/* Location: ./application/views/clients/index.php */
