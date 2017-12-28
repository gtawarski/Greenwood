app.controller ('interchangeController', function ($scope, interchangeService, UniversalCommunication, $window, $upload) {
	$scope.loading = true;
	$scope.loadingMessage = "Initializing interface";
	$scope.clientDetail = null;
	$scope.clientDetailLogo = null;
	$scope.clientNew = null;
	$scope.clientUsers = null;
	$scope.clientUser = null;
	$scope.currentPage = 1;
	$scope.nameSearch = '';

	$scope.$on('messageUpdated', function() {
		$scope.loading = true;
		$scope.loadingMessage = UniversalCommunication.updateMessage;
	});

	$scope.cancel_clientUser = function () {
		$scope.clientUser = null;
	}

	$scope.delete_clientDetail = function () {
		if (confirm('Are you sure you wish to delete this client?')) {
			$scope.loading = true;
			$scope.loadingMessage = "Deleting user";
			
			response = interchangeService.delete_clientDetail($scope.clientDetail);
			response.then (function (value) {
				$scope.currentPage = 1;
				$scope.get_clients();
			});
		}
	}

	$scope.delete_clientUser = function (user) {
		if (confirm('Are you sure you wish to delete this user?')) {
			response = interchangeService.delete_clientUser(user);
			response.then (function (value) {
				$scope.clientUser = null;
				$scope.get_clientUsers($scope.clientUsers.client);
			});
		}
	}

	$scope.delete_logo = function () {
		if (confirm('Are you sure you wish to erase the custom logo?')) {
			response = interchangeService.delete_logo($scope.clientDetail);
			response.then (function (value) {
				$scope.get_clientDetail($scope.clientDetail);
			});
		}
	}

	$scope.get_clients = function () {
		$scope.loading = true;
		$scope.loadingMessage = "Loading records from database";
		$scope.clientDetail = null;
		$scope.clientNew = null;
		$scope.clientUsers = null;
		$scope.clientUser = null;

		clients = interchangeService.get_clients({currentPage: $scope.currentPage, filterNameSearch: $scope.filterNameSearch});
		clients.then (function (value) {
			$scope.records = value.records;
			$scope.itemCount = value.itemCount;
			$scope.loading = false;
			$scope.loadingMessage = null;
		}).catch (function (value) {
			$scope.loading = false;
			$scope.loadingMessage = null;
		});
	}

	$scope.get_clientDetail = function (client) {
		$scope.loading = true;
		$scope.loadingMessage = "Loading record from database";
		$scope.clientDetail = null;
		$scope.clientNew = null;
		$scope.clientUsers = null;
		$scope.clientUser = null;

		if (client !== null) {
			response = interchangeService.get_clientDetail(client);
			response.then (function (value) {
				$scope.clientDetail = value.record;
				$scope.loading = false;
				$scope.loadingMessage = null;
			});
		} else {
			$scope.clientNew = {
				clients_id: null,
				clients_name: null,
				errorMessage: null
			}

			$scope.loading = false;
			$scope.loadingMessage = null;
		}
	}

	$scope.get_clientFiles = function (client) {
		console.log (client);
		$scope.loading = true;
		$scope.loadingMessage = "Redirecting to file list";

		response = interchangeService.get_clientFiles(client);
		response.then (function (value) {
			$window.location.href = '/files';
		});
	}

	$scope.get_clientUser = function (user) {
		if (user == null) {
			user = {
				users_id: null,
				users_firstname: null,
				users_lastname: null,
				users_email: null,
				accessConfigs_id: null
			};
		}
		$scope.clientUser = user;
	}

	$scope.get_clientUsers = function (client) {
		$scope.loading = true;
		$scope.loadingMessage = "Loading records from database";
		$scope.clientDetail = null;
		$scope.clientNew = null;
		$scope.clientUsers = {client: null, records: null};
		$scope.clientUser = null;

		response = interchangeService.get_clientUsers(client);
		response.then (function (value) {
			$scope.clientUsers.client = client;
			$scope.clientUsers.records = value.records;
			$scope.loading = false;
			$scope.loadingMessage = null;
		});
	}

	$scope.patch_clientDetail = function () {
		$scope.loading = true;
		$scope.loadingMessage = "Updating client";

		if ($scope.clientDetailLogo == null) {
			response = interchangeService.patch_clientDetail($scope.clientDetail);
			response.then (function (value) {
				$scope.get_clientDetail($scope.clientDetail);
			});
		} else {
			$upload
				.upload({
					url: '/ajax/clients/patch_clientDetailWithLogo',
					fields: $scope.clientDetail,
					file: $scope.clientDetailLogo
				})
				.progress(function (evt) {
					var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
					console.log('progress: ' + progressPercentage + '% ' +
					evt.config.file.name);
				})
				.success(function (data, status, headers, config) {
					console.log('file ' + config.file.name + 'uploaded. Response: ' +
					JSON.stringify(data));
					$scope.clientDetailLogo = null;
					$scope.get_clientDetail(data.data);
				});
		}
	}

	$scope.put_clientNew = function () {
		if ($scope.clientNew.clients_name.length < 3) {
			$scope.clientNew.errorMessage = 'A client name should be at least 3 character';
			return;
		}

		$scope.loading = true;
		$scope.loadingMessage = "Creating client";

		response = interchangeService.put_clientNew($scope.clientNew);
		response.then (function (value) {
			$scope.clientNew.clients_id = value.clients_id;
			delete $scope.clientNew.errorMessage;
			$scope.get_clientDetail($scope.clientNew);
		});
	}

	$scope.put_clientUser = function () {
		var clientUser = {
			users_id: $scope.clientUser.users_id,
			users_firstname: $scope.clientUser.users_firstname,
			users_lastname: $scope.clientUser.users_lastname,
			users_email: $scope.clientUser.users_email,
			clients_id: $scope.clientUsers.client.clients_id,
			accessConfigs_id: $scope.clientUser.accessConfigs_id
		};

		$scope.loading = true;
		$scope.loadingMessage = "Writing user";

		response = interchangeService.put_clientUser(clientUser);
		response.then (function (value) {
			$scope.clientUser = null;
			$scope.get_clientUsers($scope.clientUsers.client);
		});
	}

	$scope.get_clients();
});