app.controller ('interchangeController', function ($scope, interchangeService, UniversalCommunication, $window, $upload) {
	$scope.loading = true;
	$scope.loadingMessage = "Initializing interface";
	$scope.records = null;
	$scope.newsRecord = null;
	
	$scope.$on('messageUpdated', function() {
		$scope.loading = true;
		$scope.loadingMessage = UniversalCommunication.updateMessage;
	});

	$scope.delete_newsRecord = function (record) {
		if (confirm('Are you sure you wish to delete this article?')) {
			$scope.loadingMessage = "Deleting Record";
			$scope.loading = true;

			response = interchangeService.delete_newsRecord(record);
			response.then (function (value) {
				$scope.get_news();
			});
		}
	}

	$scope.get_news = function () {
		$scope.loadingMessage = "Loading Records";
		$scope.loading = true;

		response = interchangeService.get_news();
		response.then (function (value) {
			$scope.records = value.records;
			$scope.newsRecord = null;
			$scope.loading = false;
			$scope.loadingMessage = null;
		});
	}

	$scope.get_newsRecord = function (record) {
		$scope.loadingMessage = "Loading Record";
		$scope.loading = true;

		if (record == null) {
			$scope.newsRecord = {
				id: null,
				title: null,
				subtitle: null,
				content: null,
			};

			$scope.loading = false;
			$scope.loadingMessage = null;

		} else {
			response = interchangeService.get_newsRecord(record);
			response.then (function (value) {
				$scope.newsRecord = value.record;

				$scope.loading = false;
				$scope.loadingMessage = null;
			});
		}
	}

	$scope.put_newsRecord = function () {
		$scope.loadingMessage = "Saving Record";
		$scope.loading = true;

		response = interchangeService.put_newsRecord($scope.newsRecord);
		response.then (function (value) {
			$scope.newsRecord = null;
			$scope.get_news();
		});
	}

	$scope.get_news();
});