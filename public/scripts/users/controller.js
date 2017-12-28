app.controller ('interchangeController', function ($scope, interchangeService, UniversalCommunication, $window, $upload) {
	$scope.loading = true;
	$scope.loadingMessage = "Initializing interface";
	$scope.passwordType = "password";
	$scope.errors = new Array;
	$scope.users = null;
	$scope.userDetail = null;
	$scope.userNew = null;
	$scope.brokers = null;
	$scope.clients = null;
	$scope.currentPage = 1;
	$scope.nameSearch = '';
	
	$scope.$on('messageUpdated', function() {
		$scope.loading = true;
		$scope.loadingMessage = UniversalCommunication.updateMessage;
	});

	$scope.get_users = function () {
		$scope.loading = true;
		$scope.loadingMessage = "Loading records from database";
		$scope.errors = new Array;
		$scope.userDetail = null;
		$scope.brokers = null;
		$scope.clients = null;

		brokers = interchangeService.service_call('users', 'get_users', {currentPage: $scope.currentPage, filterNameSearch: $scope.filterNameSearch});
		brokers.then (function (value) {
			$scope.users = value.records;
			$scope.itemCount = value.itemCount;
			$scope.loading = false;
			$scope.loadingMessage = null;
		}).catch (function (value) {
			$scope.loading = false;
			$scope.loadingMessage = null;
		});
	}

	$scope.get_userDetail = function (user) {
		$scope.loading = true;
		$scope.loadingMessage = "Loading record from database";
		$scope.errors = new Array;
		$scope.passwordType = "password";
		$scope.userDetail = null;
		$scope.brokers = null;
		$scope.clients = null;

		if (user !== null) {
			response = interchangeService.service_call('users', 'get_userDetail', user);
			response.then (function (value) {
				$scope.brokers = value.brokers;
				$scope.clients = value.clients;
				$scope.userDetail = value.record;
				
				$scope.loading = false;
				$scope.loadingMessage = null;
			});
		} else {
			response = interchangeService.service_call('users', 'get_userDetail', {users_id: null});
			response.then (function (value) {
				$scope.brokers = value.brokers;
				$scope.clients = value.clients;
				$scope.userDetail = value.record;

				$scope.loading = false;
				$scope.loadingMessage = null;
			});
		}
	}

	$scope.put_userNew = function () {
		$scope.errors = new Array;
		if ($scope.userDetail.users_firstname == "" || $scope.userDetail.users_firstname == null) {
			$scope.errors.push("First name is blank");
		}

		if ($scope.userDetail.users_lastname == "" || $scope.userDetail.users_lastname == null) {
			$scope.errors.push("Last name is blank");
		}

		if ($scope.userDetail.users_email == "" || $scope.userDetail.users_email == null || $scope.userDetail.users_email == undefined) {
			$scope.errors.push("User must have a valid email address");
		}
		
		if ($scope.errors.length == 0) {
			$scope.loading = true;
			$scope.loadingMessage = "Attempting to create user...";
			
			response = interchangeService.service_call('users', 'put_userNew', $scope.userDetail);
			response.then (function (value) {
				if (value.success) {
					$scope.get_users();
				} else {
					$scope.errors.push(value.error);
					$scope.loading = false;
					$scope.loadingMessage = null;
				}
			});
		}
	}

	$scope.delete_userDetail = function () {
		if (confirm('Are you sure you wish to delete this user?')) {
			response = interchangeService.service_call('users', 'delete_userDetail', $scope.userDetail);
			response.then (function (value) {
				$scope.currentPage = 1;
				$scope.get_users();
			});
		}
	}

	$scope.show_password = function () {
		if($scope.passwordType == "password") {
			$scope.passwordType = "text";
		} else {
			$scope.passwordType = "password";
		}
	}

	$scope.get_users();
});
