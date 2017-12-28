app.service('interchangeService', function ($http, $q) {
	this.get_login = function (email, password) {

		var deferred = $q.defer();
		var results = $http.post('/ajax/system/get_login', 'email=' + email + '&password=' + password);

		results.success(function (data, status, headers, config) {	
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */
		
		return deferred.promise;
	}

	this.put_activation = function (data) {

		var deferred = $q.defer();
		var results = $http.post('/ajax/system/put_activation', $.param(data));

		results.success(function (data, status, headers, config) {	
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */
		
		return deferred.promise;
	}

	this.put_resetPassword = function (data) {

		var deferred = $q.defer();
		var results = $http.post('/ajax/system/put_resetPassword', $.param(data));

		results.success(function (data, status, headers, config) {	
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */
		
		return deferred.promise;
	}
});