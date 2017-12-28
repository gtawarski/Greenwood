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
	<body class="login" ng-app="mainApp">
		<noscript>
			<div class="row">
				<div class="col-md-offset-3 col-md-6 alert alert-danger" role="alert">
					<strong>Warning</strong>: JAVASCRIPT MUST BE ENABLED FOR THIS SITE TO WORK PROPERLY!
				</div>
			</div>
		</noscript>

		<div class="container container-full" ng-controller="interchangeController">
			<div class="row" ng-show="loading">
				<div class="col-xs-12 text-center">
					<div class="well">Communicating with Server <span class="fa fa-spinner fa-spin"></span><br /><span ng-bind-html="loadingMessage"></span></div>
				</div>
			</div>

			<div class="row ng-hide" ng-hide="loading">
				<div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0">

<?php
/* End of file header_login.php */
/* Location: ./application/views/general/header_login.php */
