var app = angular.module('mainApp', ['ngSanitize', 'ui.bootstrap', 'angularFileUpload', 'textAngular']);

app.config(['$httpProvider', function ($httpProvider) {
	$httpProvider.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
}]);

app.directive('ngEnter', function () {
	return function (scope, element, attrs) {
		element.bind("keydown keypress", function (event) {
			if(event.which === 13) {
				scope.$apply(function (){
					scope.$eval(attrs.ngEnter);
				});
				event.preventDefault();
			}
		});
	};
});

app.directive('targetBlank', function() {
	return {
		compile: function(element) {
			var elems = (element.prop("tagName") === 'A') ? element : element.find('a');
			elems.attr("target", "_blank");
		}
	};
});

app.factory('UniversalCommunication', function ($rootScope) {
	var service = {};
	service.updateMessage = null;

	service.setUpdateContent = function (text) {
		service.updateMessage = text;
		$rootScope.$broadcast("messageUpdated");
	}

	return service;
});