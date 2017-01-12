(function(){
	angular.module('Eve')
	.factory('character', ['$http', function($http) {
		//TODO [milestone2]: Repository of many Corp  character API keys
		return { 
			id : '{character id}',
			api_key : '{character api key}',
			api_vcode : '{character api vcode}'
		}
	}])

})();