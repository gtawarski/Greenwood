app.controller ('interchangeController', function ($scope, interchangeService, UniversalCommunication, $window, $upload) {
	$scope.loading = true;
	$scope.loadingMessage = "Initializing interface";
	$scope.brokerDetail = null;
	$scope.brokerDetailLogo = null;
	$scope.brokerNew = null;
	$scope.brokerUsers = null;
	$scope.brokerUser = null;
	$scope.currentPage = 1;
	$scope.nameSearch = '';

	$scope.$on('messageUpdated', function() {
		$scope.loading = true;
		$scope.loadingMessage = UniversalCommunication.updateMessage;
	});

	$scope.cancel_brokerUser = function () {
		$scope.brokerUser = null;
	}

	$scope.delete_brokerDetail = function () {
		if (confirm('Are you sure you wish to delete this broker?')) {
			response = interchangeService.delete_brokerDetail($scope.brokerDetail);
			response.then (function (value) {
				$scope.currentPage = 1;
				$scope.get_brokers();
			});
		}
	}

	$scope.delete_brokerUser = function (user) {
		if (confirm('Are you sure you wish to delete this user?')) {
			$scope.loading = true;
			$scope.loadingMessage = "Deleting user";

			response = interchangeService.delete_brokerUser(user);
			response.then (function (value) {
				$scope.brokerUser = null;
				$scope.get_brokerUsers($scope.brokerUsers.broker);
			});
		}
	}

	$scope.delete_logo = function () {
		if (confirm('Are you sure you wish to erase the custom logo?')) {
			response = interchangeService.delete_logo($scope.brokerDetail);
			response.then (function (value) {
				$scope.get_brokerDetail($scope.brokerDetail);
			});
		}
	}

	$scope.get_brokers = function () {
		$scope.loading = true;
		$scope.loadingMessage = "Loading records from database";
		$scope.brokerDetail = null;
		$scope.brokerNew = null;
		$scope.brokerUsers = null;
		$scope.brokerUser = null;

		brokers = interchangeService.get_brokers({currentPage: $scope.currentPage, filterNameSearch: $scope.filterNameSearch});
		brokers.then (function (value) {
			$scope.records = value.records;
			$scope.itemCount = value.itemCount;
			$scope.loading = false;
			$scope.loadingMessage = null;
		}).catch (function (value) {
			$scope.loading = false;
			$scope.loadingMessage = null;
		});
	}

	$scope.get_brokerDetail = function (broker) {
		$scope.loading = true;
		$scope.loadingMessage = "Loading record from database";
		$scope.brokerDetail = null;
		$scope.brokerNew = null;
		$scope.brokerUsers = null;
		$scope.brokerUser = null;

		if (broker !== null) {
			response = interchangeService.get_brokerDetail(broker);
			response.then (function (value) {
				$scope.brokerDetail = value.record;
				$scope.loading = false;
				$scope.loadingMessage = null;
			});
		} else {
			$scope.brokerNew = {
				brokers_id: null,
				brokers_name: null,
				errorMessage: null
			}

			$scope.loading = false;
			$scope.loadingMessage = null;
		}
	}

	$scope.get_brokerUser = function (user) {
		if (user == null) {
			user = {
				users_id: null,
				users_firstname: null,
				users_lastname: null,
				users_email: null,
				accessConfigs_id: null
			};
		}
		$scope.brokerUser = user;
	}

	$scope.get_brokerUsers = function (broker) {
		$scope.loading = true;
		$scope.loadingMessage = "Loading records from database";
		$scope.brokerDetail = null;
		$scope.brokerNew = null;
		$scope.brokerUsers = {broker: null, record: null};
		$scope.brokerUser = null;

		response = interchangeService.get_brokerUsers(broker);
		response.then (function (value) {
			$scope.brokerUsers.broker = broker;
			$scope.brokerUsers.records = value.records;
			$scope.loading = false;
			$scope.loadingMessage = null;
		});
	}

	$scope.patch_brokerDetail = function () {
		$scope.loading = true;
		$scope.loadingMessage = "Updating broker";

		if ($scope.brokerDetailLogo == null) {
			response = interchangeService.patch_brokerDetail($scope.brokerDetail);
			response.then (function (value) {
				$scope.get_brokerDetail($scope.brokerDetail);
			});
		} else {
			$upload
				.upload({
					url: '/ajax/brokers/patch_brokerDetailWithLogo',
					fields: $scope.brokerDetail,
					file: $scope.brokerDetailLogo
				})
				.progress(function (evt) {
					var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
					console.log('progress: ' + progressPercentage + '% ' +
					evt.config.file.name);
				})
				.success(function (data, status, headers, config) {
					console.log('file ' + config.file.name + 'uploaded. Response: ' +
					JSON.stringify(data));
					$scope.brokerDetailLogo = null;
					$scope.get_brokerDetail(data.data);
				});
		}
	}

	$scope.put_brokerNew = function () {
		if ($scope.brokerNew.brokers_name.length < 3) {
			$scope.brokerNew.errorMessage = 'A broker name should be at least 3 character';
			return;
		}

		$scope.loading = true;
		$scope.loadingMessage = "Creating broker";

		response = interchangeService.put_brokerNew($scope.brokerNew);
		response.then (function (value) {
			$scope.brokerNew.brokers_id = value.brokers_id;
			delete $scope.brokerNew.errorMessage;
			$scope.get_brokerDetail($scope.brokerNew);
		});
	}

	$scope.put_brokerUser = function () {
		var brokerUser = {
			users_id: $scope.brokerUser.users_id,
			users_firstname: $scope.brokerUser.users_firstname,
			users_lastname: $scope.brokerUser.users_lastname,
			users_email: $scope.brokerUser.users_email,
			brokers_id: $scope.brokerUsers.broker.brokers_id,
			accessConfigs_id: $scope.brokerUser.accessConfigs_id
		};

		$scope.loading = true;
		$scope.loadingMessage = "Writing user";

		response = interchangeService.put_brokerUser(brokerUser);
		response.then (function (value) {
			$scope.brokerUser = null;
			$scope.get_brokerUsers($scope.brokerUsers.broker);
		});
	}

	$scope.get_brokers();
});