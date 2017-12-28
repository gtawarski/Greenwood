<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<head language="en">
	<head>
		<title>INTERCHANGE</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!--GENERIC BASE-->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

		<!--BOOSTRAP STUFF-->
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.0.0/js/bootstrap-datetimepicker.min.js"></script>

		<!--ANGULAR STUFF-->
		<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.6/angular.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.6/angular-animate.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.6/angular-sanitize.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.12.0/ui-bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.12.0/ui-bootstrap-tpls.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.1.0/es5-shim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.1.0/es5-sham.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/textAngular/1.3.6/dist/textAngular-rangy.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/textAngular/1.3.6/dist/textAngular-sanitize.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/textAngular/1.3.6/dist/textAngular.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/3.1.2/angular-file-upload-shim.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/3.1.2/angular-file-upload.min.js"></script>

		<!--CSS STUFF-->
		<link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" type="text/css" rel="stylesheet" />
		<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
		<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" />
		<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
		<link href="//cdnjs.cloudflare.com/ajax/libs/textAngular/1.3.6/src/textAngular.css" type="text/css" rel="stylesheet">

		<!--OTHER STYLE STUFF-->
		<link href='//fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
		<link href='/styles/interchange.css' rel='stylesheet' type='text/css'>
	</head>
	<body class="secure" ng-app="mainApp">
		<!--NAV BAR WILL GO HERE-->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" ng-controller="profileController as profile">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNavigation">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" id="systemName" href="/home">INTERCHANGE</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="mainNavigation">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="/system/logout">Logout</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>

		<div class="container container-full" ng-controller="interchangeController">
			<div class="row" ng-show="loading">
				<div class="col-xs-12 text-center">
					<div class="well">Communicating with Server <span class="fa fa-spinner fa-spin"></span><br /><span ng-bind-html="loadingMessage"></span></div>
				</div>
			</div>

<?php
/* End of file header_secure.php */
/* Location: ./application/views/general/header_secure.php */
