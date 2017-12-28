app.controller ('interchangeController', function ($scope, interchangeService, UniversalCommunication, $window) {
	$scope.loading = false;

	$scope.$on('messageUpdated', function() {
		$scope.loading = true;
		$scope.loadingMessage = UniversalCommunication.updateMessage;
	});
});