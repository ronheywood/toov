(function(){
	angular.module('Eve')
	.service('marketService',function($http){
		var market = {
        get: function(resource) {
            var apiBase = 'http://api.eve-central.com/api';
            
            // $http returns a promise, which has a then function, which also returns a promise
            var promise = $http.get(apiBase + resource).then(function (response) {
                // The return value gets picked up by the then in the controller.
                return response.data;
              },
              function(error){
                console.error(error.status);
                alert('Market API http Error');
              });
              // Return the promise to the controller
              return promise;
        }
    	};
    	return market;
	})
})()