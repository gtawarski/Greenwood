app.service('interchangeService', function ($http, $q) {
	this.service_call = function (service, method, parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/'+service+'/'+method, $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}
});