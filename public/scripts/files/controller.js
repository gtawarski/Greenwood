app.controller ('interchangeController', function ($scope, $window, interchangeService, UniversalCommunication, $upload) {
	//GENERAL INIT
	$scope.loading = true;
	$scope.loadingMessage = 'Initializing Interface';
	$scope.filterClientsModel = null;
	$scope.filterTagsModel = null;
	$scope.records = null;
	$scope.recordsDetails = false;
	$scope.fileData = null;
	$scope.fileUpload = false;
	$scope.fileUploadAvailable = false;
	$scope.fileLog = null;

	$scope.$watch('files', function () {
        $scope.upload($scope.files);
    });

	$scope.delete_file = function () {
		if (confirm('Are you sure you wish to delete this file?')) {
			$scope.loading = true;
			$scope.loadingMessage = 'Deleting File';

			response = interchangeService.delete_file($scope.fileData);
			response.then (function (value) {
				$scope.get_files();
			});
		}
	}


	$scope.get_filesInit = function () {
		response = interchangeService.get_filesInit();
		response.then (function (value) {
			$scope.filterClients = value.filterClients;
			$scope.uploadClients = value.filterClients;
			if (value.filterClientsDefault !== false) {
				$scope.filterClientsModel = value.filterClientsDefault;	
				$scope.filterUploadClientsModel = value.filterClientsDefault;	
			} else {
				$scope.filterClientsModel = $scope.filterClients[0];
				$scope.filterUploadClientsModel = $scope.filterClients[0];
			}

			$scope.fileUploadAvailable = value.recordsDetails;
			$scope.recordsDetails = value.recordsDetails;
			$scope.filterTags = value.filterTags;
			$scope.filterTagsModel = $scope.filterTags[0];

			$scope.get_files();
		});
	}

	$scope.get_files = function () {
		$scope.loading = true;
		$scope.loadingMessage = 'Retrieving Files';
		$scope.fileData = null;
		$scope.fileUpload = false;
		$scope.fileLog = null;

		var filter = {
			clients_id: $scope.filterClientsModel.clients_id,
			clients_name: $scope.filterClientsModel.clients_name,
			fileTags_id: $scope.filterTagsModel.id
		}
		
		response = interchangeService.get_files(filter);
		response.then (function (value) {
			$scope.records = value.records;

			$scope.loading = false;
			$scope.loadingMessage = null;
		});
	}

	$scope.get_file = function (file) {
		$scope.loading = true;
		$scope.loadingMessage = 'Loading Database Record';

		response = interchangeService.get_file(file);
		response.then (function (value) {
			$scope.fileData = value.data;

			$scope.loading = false;
			$scope.loadingMessage = null;
		});
	}

	$scope.get_fileUpload = function () {
		$scope.fileUpload = true;
		$scope.fileLog = Array();

	}

	$scope.patch_file = function () {
		$scope.loading = true;
		$scope.loadingMessage = 'Updating File';

		response = interchangeService.patch_file($scope.fileData);
		response.then (function (value) {
			$scope.get_files();
		});
	}

	$scope.upload = function (files) {
		if (files && files.length) {
			for (var i = 0; i < files.length; i++) {
				var file = files[i];
				$upload.upload({
					url: '/files/upload_file',
					fields: {
						clients_id: $scope.filterUploadClientsModel.clients_id,
						fileTags_id: $scope.filterUploadfileTags_id
					},
					file: file
				}).progress(function (evt) {
					var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
					console.log('progress: ' + progressPercentage + '% ' +
					evt.config.file.name);
				}).success(function (data, status, headers, config) {
					$scope.fileLog.push(config.file.name + ' Uploaded');
				});
			}
		}
	};

	$scope.get_filesInit();

});