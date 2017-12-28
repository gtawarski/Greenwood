app.service('interchangeService', function ($http, $q) {
	this.delete_newsRecord = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/news/delete_newsRecord',  $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_news = function () {
		var deferred = $q.defer();
		var results = $http.post('/ajax/news/get_news');

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.get_newsRecord = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/news/get_newsRecord', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}

	this.put_newsRecord = function (parameters) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/news/put_newsRecord', $.param(parameters));

		results.success(function (data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */

		return deferred.promise;
	}
});