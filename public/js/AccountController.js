(function(){
	angular.module('Eve')
	.controller("AccountController",['$scope','crestService', '$sce', 'character','images', function($scope, crestService, $sce,character,images){

			var action = '/characters/'+character.id+'/';
			var _self = this;

		   crestService.get(action).then(
		   	function(eve_character) {
		   		
		        _self.character = eve_character;
		        $scope.character = _self.character;

		    });

		   $scope.characterImage = function(width){
		   		return $sce.trustAsHtml(images.imageForCharacter(_self.character,width));
		   }

		}])
})();