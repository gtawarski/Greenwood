app.service('profileService', function ($http, $q) {

	this.get_remainingTime = function () {
		var deferred = $q.defer();
		var results = $http.post('/ajax/secure');

		results.success(function (data, status, headers, config) {	
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */
		
		return deferred.promise;
	}

	this.set_profile = function (id) {
		var deferred = $q.defer();
		var results = $http.post('/ajax/profile/set_activeProfileById', $.param({profile_id: id}));

		results.success(function (data, status, headers, config) {	
			deferred.resolve(data);
		}).error(function(data, status, headers, config){
			deferred.reject(status);
		});/* results */
		
		return deferred.promise;
	}
});