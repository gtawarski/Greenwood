app.controller ('interchangeController', function ($scope, interchangeService, $window) {
	$scope.loading = false;

	$scope.login = true;
	$scope.loginEmail = '';
	$scope.loginPassword = '';

	$scope.reset = false;

	$scope.activate = false;
	$scope.activation = {
		email: '',
		registration: '',
		password: '',
		confirmPassword: ''
	};

	$scope.loginMessage = null;
	$scope.activationMessage = null;
	$scope.resetMessage = null;

	$scope.get_login = function () {
		$scope.loginMessage = null;
		
		$scope.loading = true;
		$scope.login = true;
		$scope.reset = false;
		$scope.loading = false;
	}

	$scope.get_signIn = function () {
		$scope.loginMessage = null;
		$scope.activationMessage = null;
		$scope.resetMessage = null;
		
		response = interchangeService.get_login ($scope.loginEmail, $scope.loginPassword);
		response.then (function (value) {
			if (value.success) {
				$window.location.href = value.location;
			} else {
				$scope.loginMessage =  value.message;
				}
		}).catch (function (value) {
			$scope.loginMessage =  'Login not currently available';
		});
	}

	$scope.get_passwordReset = function () {
		$scope.loginMessage = null;
		$scope.activationMessage = null;
		$scope.resetMessage = null;

		$scope.loading = true;
		$scope.login = false;
		$scope.reset = true;
		$scope.loading = false;
	}

	$scope.put_activation = function () {
		$scope.loginMessage = null;
		$scope.activationMessage = null;
		$scope.resetMessage = null;

		if (
			($scope.activation.email == '') ||
			($scope.activation.registration == '') ||
			($scope.activation.password == '') ||
			($scope.activation.confirmPassword == '')
		) {
			$scope.activationMessage = 'You must fill in all fields';
			return;
		}

		if ($scope.activation.password.length < 8) {
			$scope.activationMessage = 'Your new password must be at least 8 characters';
			return;
		}

		if ($scope.activation.password != $scope.activation.confirmPassword) {
			$scope.activationMessage = 'Your password and confirmation do not match';
			return;
		}

		response = interchangeService.put_activation ($scope.activation);
		response.then (function (value) {
			if (value.success) {
				$window.location.href = value.location;
				//console.log (value.location);
			} else {
				$scope.activationMessage = value.message;
			}
		}).catch (function (value) {
			$scope.activationMessage = 'Activation not currently available';
		});
	}

	$scope.put_resetPassword = function () {
		$scope.loginMessage = null;
		$scope.activationMessage = null;
		$scope.resetMessage = null;

		response = interchangeService.put_resetPassword ({email: $scope.resetEmail});
		response.then (function (value) {
			if (value.success) {
				$scope.resetMessage = value.message;
			} else {
				$scope.resetMessage = value.message;
			}
		}).catch (function (value) {
			$scope.resetMessage = 'Reset not currently available';
		});
	};
});