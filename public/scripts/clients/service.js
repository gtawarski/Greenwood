app.service('interchangeService', function ($http, $q) {
	this.delete_clientDetail = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/delete_clientDetail', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.delete_clientUser = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/delete_clientUser', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.delete_logo = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/delete_logo', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.put_clientUser = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/put_clientUser', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_clients = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/get_clients', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_clientFiles = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/get_clientFiles', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_clientUsers = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/get_clientUsers', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_clientDetail = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/get_clientDetail', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.patch_clientDetail = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/patch_clientDetail', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.put_clientNew = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/put_clientNew', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.put_clientUser = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/clients/put_clientUser', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}
});