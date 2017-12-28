app.service('interchangeService', function ($http, $q) {
	this.delete_brokerDetail = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/delete_brokerDetail', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.delete_brokerUser = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/delete_brokerUser', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.delete_logo = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/delete_logo', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.put_brokerUser = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/put_brokerUser', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_brokers = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/get_brokers', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_brokerUsers = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/get_brokerUsers', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_brokerDetail = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/get_brokerDetail', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.patch_brokerDetail = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/patch_brokerDetail', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.put_brokerNew = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/put_brokerNew', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.put_brokerUser = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/brokers/put_brokerUser', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}
});