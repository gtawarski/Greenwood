app.service('interchangeService', function ($http, $q) {
	this.get_homeInit = function () {
		var deferred = $q.defer();
		var results = $http.post('/ajax/home/get_init');

		results.success(function (data, status, headers, config) {	
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */
		
		return deferred.promise;
	}

	this.patch_account = function (account) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/home/patch_account', $.param(account));

		results.success(function (data, status, headers, config) {	
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */
		
		return deferred.promise;
	}	
});