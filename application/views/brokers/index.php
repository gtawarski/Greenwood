<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--GENERAL CLIENT LISTER-->
<div class="row ng-hide" ng-hide="loading || brokerDetail || brokerNew || brokerUsers" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="filter_brokerName" class="control-label col-xs-12 col-sm-2">Name</label>
					<div class="col-xs-12 col-sm-10">
						<div class="input-group">
							<input type="text" ng-model="filterNameSearch" class="form-control" placeholder="Search for broker named..." ng-enter="currentPage=1;get_brokers()">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" ng-click="currentPage=1;get_brokers()">Search</button>
							</span>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row" ng-hide="loading || brokerDetail || brokerNew || brokerUsers" ng-cloak>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" ng-repeat="record in records track by record.brokers_id">
		<div class="well fixed-height-250 text-center">
			<h2>{{record.brokers_name}}</h2>
			<p><img ng-src="/brokers/get_brokerLogo/{{record.brokers_id}}/{{record.brokers_datetime}}" height="100px" /></p>
			<div class="text-center">
				<button type="button" class="btn btn-info" ng-click="get_brokerDetail(record)">
					Edit
				</button>
				<button type="button" class="btn btn-success" ng-click="get_brokerUsers(record)">
					Users
				</button>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="well fixed-height-250">
			<h2 class="text-center">Add a new broker</h2>
			<div class="text-center">
				<button type="button" class="btn btn-info" ng-click="get_brokerDetail(null)">
					<span class="fa fa fa-users fa-5x"></spin>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="text-center" ng-hide="loading || brokerDetail || brokerNew || brokerUsers" ng-cloak>
	<div class="well">
		<pagination total-items="recordsItemCount" boundary-links="true" items-per-page="12" max-size="7" ng-model="currentPage" ng-change="get_brokers()" num-pages="numPages"></pagination>
		<div>Page: {{currentPage}} / {{numPages}}</div>
	</div>
</div>
<!--END GENERAL CLIENT LISTER-->

<!--CLIENT DETAIL-->
<div class="row" ng-show="!loading && brokerDetail" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<h1>Update a Broker</h1>
			<p>To update a broker account, alter the account name.</p>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-sm-5 control-label">Broker Name</label>
					<div class="col-sm-6">
						<input type="text" class="form-control"  ng-model="brokerDetail.brokers_name" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">Broker Logo</label>
					<div class="col-sm-1">
						<button class="btn btn-primary" ng-file-select ng-model="brokerDetailLogo" ng-multiple="multiple" ng-accept="'.jpg,.jpeg,.png'">Select File</button>
					</div>
					<div class="col-sm-6">
						{{brokerDetailLogo[0].name}}
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
						<img ng-src="/brokers/get_brokerLogo/{{brokerDetail.brokers_id}}/{{brokerDetail.brokers_datetime}}" height="100" width="100" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<button class="btn btn-success" type="button" ng-click="patch_brokerDetail();">Update <span class="glyphicon glyphicon-ok-circle"></span></button>
						<button class="btn btn-warning" type="button" ng-click="get_brokers();">Close <span class="glyphicon glyphicon-remove-circle"></span></button>
						<button class="btn btn-danger" type="button" ng-click="delete_brokerDetail();">Delete <span class="glyphicon glyphicon-trash"></span></button>
					</div>
				</div>
			</form>
			<hr />
		</div>
	</div>
</div>
<!--END CLIENT DETAIL-->

<!--CLIENT NEW-->
<div class="row" ng-show="!loading && brokerNew" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<h1>Add a new Broker</h1>
			<form class="form-horizontal" role="form">
				<div class="row" ng-show="brokerNew.errorMessage">
					<div class="col-sm-12">
						<div class="alert alert-danger" role="alert">{{brokerNew.errorMessage}}</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Broker Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control"  ng-model="brokerNew.brokers_name" ng-change="brokerNew.errorMessage=null" ng-enter="put_brokerNew();" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<button class="btn btn-success" type="button" ng-click="put_brokerNew();">Create <span class="glyphicon glyphicon-ok-circle"></span></button>
						<button class="btn btn-danger" type="button" ng-click="get_brokers();">Cancel <span class="glyphicon glyphicon-ban-circle"></span></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!--END CLIENT NEW-->

<!--CLIENT USERS-->
<div class="row" ng-show="!loading && brokerUsers" ng-cloak>
	<div class="col-xs-12">
		<div class="well">
			<div class="row">
				<div class="col-xs-12">
					<h1>User Management - {{brokerUsers.broker.brokers_name}}</h1>
				</div>
			</div>
			<div class="row" ng-hide="brokerUser">
				<div class="col-xs-12">
					<button class="btn btn-warning" type="button" ng-click="get_brokers();">Close <span class="glyphicon glyphicon-remove-circle"></span></button>
					<button class="btn btn-success" type="button" ng-click="get_brokerUser(null);">Add New User <span class="glyphicon glyphicon-ok-circle"></span></button>
				</div>
			</div>
			<div class="row" ng-hide="brokerUser">
				<div class="col-sm-12 col-md-4" ng-repeat="user in brokerUsers.records track by user.users_id">
					<div class="well">
						<p>{{user.users_firstname}} {{user.users_lastname}}</p>
						<p><small>{{user.users_email}}</small></p>
						<p><small>{{user.accessConfigs_name}}</small></p>
						<button type="button" class="btn btn-warning" ng-click="get_brokerUser(user);">Edit <span class="glyphicon glyphicon-cog"></span></button>
						<button type="button" class="btn btn-danger" ng-click="delete_brokerUser(user);">Delete <span class="glyphicon glyphicon-trash"></span></button>
					</div>
				</div>
			</div>

			<div class="row" ng-show="brokerUser">
				<div class="col-sm-12 col-md-12">
					<form role="form">
						<div class="form-group">
							<label>User Type</label>
							<label class="radio-inline">
								<input type="radio" ng-model="brokerUser.accessConfigs_id" value="5"> Manager
							</label>
							<label class="radio-inline">
								<input type="radio" ng-model="brokerUser.accessConfigs_id" value="6"> User
							</label>
						</div>
						<div class="form-group">
							<label>Email Address</label>
    						<input type="text" class="form-control" ng-model="brokerUser.users_email" placeholder="Enter email">
						</div>
						<div class="form-group">
							<label>First Name</label>
    						<input type="text" class="form-control" ng-model="brokerUser.users_firstname" placeholder="Enter first name">
						</div>
						<div class="form-group">
							<label>Last Name</label>
    						<input type="text" class="form-control" ng-model="brokerUser.users_lastname" placeholder="Enter last name">
						</div>
						<div class="row">
							<div class="col-xs-12">
								<button class="btn btn-success" type="button" ng-click="put_brokerUser()">Save <span class="glyphicon glyphicon-ok-circle"></span></button>
								<button class="btn btn-danger" type="button" ng-click="cancel_brokerUser()">Cancel <span class="glyphicon glyphicon-ban-circle"></span></button>
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
/* Location: ./application/views/brokers/index.php */