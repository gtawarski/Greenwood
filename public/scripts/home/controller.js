app.controller ('interchangeController', function ($scope, interchangeService, UniversalCommunication, $window, $timeout) {
	$scope.loading = true;
	$scope.loadingMessage = "Initializing interface";

	$scope.myAccount = null;
	$scope.myAccountEmailChanged = false;

	$scope.updatingMyAccount = false;
	$scope.updatingMyAccountMessage = null;

	$scope.fileList = null;
	$scope.fileShowAccounts = false;
	$scope.fileShowClients = false;

	$scope.news = null;

	$scope.$on('messageUpdated', function() {
		$scope.loading = true;
		$scope.loadingMessage = UniversalCommunication.updateMessage;
	});

	initResponse = interchangeService.get_homeInit();
	initResponse.then(function (value) {
		$scope.myAccount = value.myAccount;
		
		$scope.myAccount.originalEmail = $scope.myAccount.email;
		$scope.myAccount.originalFirstname = $scope.myAccount.firstname;
		$scope.myAccount.originalLastname = $scope.myAccount.lastname;
		$scope.myAccount.newPassword = null;
		$scope.myAccount.confirmNewPassword = null;

		$scope.fileList = value.recentFiles.fileList;
		$scope.fileShowAccounts = value.recentFiles.showAccounts;
		$scope.fileShowClients = value.recentFiles.showClients;

		$scope.news = value.recentNews;

		$scope.loadingMessage = null;
		$scope.loading = false;
	});

	$scope.update_account = function () {

		$scope.updatingMyAccount = true;
		$scope.updatingMyAccountMessage = '<br />Validating!';
		$scope.updatingMyAccountMessage = '<br />Updating account information';

		if (($scope.myAccount.newPassword != "") && ($scope.myAccount.newPassword != $scope.myAccount.confirmNewPassword)) {
			$scope.updatingMyAccountMessage = '<br /><strong>Error</strong>: Password and Confirmation must match.<br /><br />Resetting accout details.';
			$scope.myAccount.newPassword = null;
			$scope.myAccount.confirmNewPassword = null;

			$timeout(function () {
				$scope.updatingMyAccountMessage = null;
				$scope.updatingMyAccount = false;
			}, 5000);

			return;
		}

		initResponse = interchangeService.patch_account($scope.myAccount);		
		initResponse.then(function (value) {
			if (value.success) {
				$scope.myAccount = value.account;

				$scope.myAccount.originalEmail = $scope.myAccount.email;
				$scope.myAccount.originalFirstname = $scope.myAccount.firstname;
				$scope.myAccount.originalLastname = $scope.myAccount.lastname;
				$scope.myAccount.newPassword = null;
				$scope.myAccount.confirmNewPassword = null;
						
				$scope.updatingMyAccountMessage = null;
				$scope.updatingMyAccount = false;
			} else {
				$scope.updatingMyAccountMessage = '<br /><strong>Error</strong>: '+value.error+'<br /><br />Resetting accout details.';
				$scope.myAccount.email = $scope.myAccount.originalEmail;
				$scope.myAccount.firstname = $scope.myAccount.originalFirstname;
				$scope.myAccount.lastname = $scope.myAccount.originalLastname;
				$scope.myAccount.newPassword = null;
				$scope.myAccount.confirmNewPassword = null;

				$timeout(function () {
					$scope.updatingMyAccountMessage = null;
					$scope.updatingMyAccount = false;
				}, 5000);
			}
		});
	}
});