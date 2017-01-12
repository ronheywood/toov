(function() {
    angular.module('Eve')
    .service('xmlService', function($http){
        var xmlService = {
        get: function(resource) {
            var xmlApi = 'https://api.eveonline.com/';
            
            // $http returns a promise, which has a then function, which also returns a promise
            var promise = $http.get(xmlApi + resource).then(function (response) {
                // The return value gets picked up by the then in the controller.
                return response.data;
              },
              function(error){
                console.error(error.status);
                alert('XML API http Error');
              });
              // Return the promise to the controller
              return promise;
        }
      };

      return xmlService;
    })
})();