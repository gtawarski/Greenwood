app.controller ('profileController', function ($scope, profileService, UniversalCommunication, $window, $interval) {
	$scope.checkout_remaining = function () {
		$interval(function () {
			var secure = profileService.get_remainingTime();
			secure.then (function (value) {
				if (value.logout == true) {
					window.location='/system/autoLogout';
				} else {
					console.log(value);
				}
			});
		}, 15000);
	}

	$scope.set_profile = function (profile_id) {
		$scope.updateContent = "Switching User Profiles - Stand By!";

		$scope.$watch('updateContent', function() {
			UniversalCommunication.setUpdateContent($scope.updateContent);
		});

		var profile = profileService.set_profile(profile_id);
		profile.then (function (value) {
			$window.location.href=value.location;
		}).catch (function (value) {

		});
	};

	$scope.checkout_remaining();
});