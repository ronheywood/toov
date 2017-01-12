(function() {
    angular.module('Eve')
    .service('toovService', function($http){
        var toov = {
        get: function(resource) {
            
            // $http returns a promise, which has a then function, which also returns a promise
            var promise = $http.get(resource).then(function (response) {
                // The return value gets picked up by the then in the controller.
                return response.data;
              },
              function(error){
                console.error(error.status);
                alert('TOOV API http Error');
              });
              // Return the promise to the controller
              return promise;
        }
      };

      return toov;
    })
})();