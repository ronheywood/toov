(function() {
    angular.module('Eve')
    .service('crestService', function($http){
        var crest = {
        get: function(resource) {
            var apiBase = 'https://crest-tq.eveonline.com';
            
            // $http returns a promise, which has a then function, which also returns a promise
            var promise = $http.get(apiBase + resource).then(function (response) {
                // The return value gets picked up by the then in the controller.
                return response.data;
              },
              function(error){
                console.error(error.status);
                alert('CREST API http Error');
              });
              // Return the promise to the controller
              return promise;
        }
      };

      return crest;
    })
})();