<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row ng-hide" ng-hide="loading" ng-cloak>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h1>Welcome to Greenwood Group</h1>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
				<div class="well">
					<h2 class="homePage"><span class="fa fa-database"></span> Newest Files</h2>
					<div class="separator-top" ng-repeat="x in fileList">
						<p tooltip="{{x.filesName}}" tooltip-placement="bottom"><strong>{{x.filesName | limitTo:30}}{{ x.filesName.length > 30 ? "..." : ""}}</strong></p>
						<p><span class="fa {{x.fileTags_fontAwesome}}"></span> {{x.fileTags_name}}</p>
						<p ng-show="fileShowClients">{{x.clientsName}}</p>
						<p>{{x.files_date}}</p>
						<p>
							<a class="btn btn-small btn-success" href="/files/get_file/{{x.files_id}}">Download <span class="fa fa-download"></span></a>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="well">
					<h2 class="homePage"><span class="fa fa-newspaper-o"></span> News and Announcements</h2>
					<div ng-repeat="article in news">
						<hr />
						<h3>{{article.news_title}}</h3>
						<h4>{{article.news_subtitle}}</h4>
						<div ng-bind-html="article.news_content"></div>
						<div><small>By: {{article.users_firstname}} {{article.users_lastname}} on {{article.news_date}}</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
				<div class="well">
					<h2 class="homePage"><span class="fa fa-user"></span> My Account Settings</h2>
					<div ng-show="updatingMyAccount">
						Communicating with Server <span class="fa fa-spinner fa-spin"></span>
						<br />
						<span ng-bind-html="updatingMyAccountMessage"></span>
					</div>
					<form ng-hide="updatingMyAccount">
						<div class="form-group">
							<label for="userFirstname" class="control-label">First Name</label>
							<input type="text" class="form-control" id="userFirstname" ng-model="myAccount.firstname">
						</div>
						<div class="form-group">
							<label for="userLastname" class="control-label">Last Name</label>
							<input type="text" class="form-control" id="userLastname" ng-model="myAccount.lastname">
						</div>
						<div class="form-group">
							<label for="userEmail" class="control-label">Email</label>
							<input type="text" class="form-control" id="userEmail" ng-model="myAccount.email">
						</div>
						<div class="form-group">
							<label for="userPassword" class="control-label">Password</label>
							<input type="password" class="form-control" id="userPassword" ng-model="myAccount.newPassword" placeholder="Password">
						</div>
						<div class="form-group">
							<label for="confirmPassword" class="control-label">Confirm Password</label>
							<input type="password" class="form-control" id="confirmPassword" ng-model="myAccount.confirmNewPassword" placeholder="Confirm Password">
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-success" ng-click="update_account();">Update My Account</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
/* End of file index.php */
/* Location: ./application/views/home/index.php */