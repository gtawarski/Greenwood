app.service('interchangeService', function ($http, $q) {
	this.delete_file = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/files/delete_file', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_filesInit = function () {
		var deferred = $q.defer();
		var results = $http.post('/ajax/files/get_filesInit');

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_files = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/files/get_files', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_file = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/files/get_file', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.patch_file = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/files/patch_file', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}
});