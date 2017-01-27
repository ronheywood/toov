(function(){
	angular.module('Eve')
	.controller("AccountController",['$scope','$cookies','crestService', '$sce', 'character','images', 
		function($scope, $cookies,crestService, $sce,character,images){

			var _self = this;

		   $scope.characterImage = function(width){
		   		if(_self.account==undefined) return  $sce.trustAsHtml('');
		   		return $sce.trustAsHtml(images.imageForCharacter(_self.account,width));
		   }

		   $scope.authenticate = function(){

		   		var authPath = 'https://login.eveonline.com/oauth/authorize/';
		   		var response_type = 'response_type=code';
				var redirect_uri = 'redirect_uri=http://localhost:8000/openauth';
				var client_id = 'client_id=4344fa43fd9d4114aa8823700af948c1';
				var scope = 'scope=publicData+characterFittingsWrite+characterAssetsRead+esi-killmails.read_killmails.v1+esi-assets.read_assets.v1';
				var action = authPath + '?%s&%s&%s&%s&%s'.format(response_type,redirect_uri,client_id,scope)

				var config = "toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=350,height=410,left=50,top=50,titlebar=yes";
				//load an iFrame in a modal and wait for authorisation
				window.location.replace(action);

		   }


			if(character.isAuthed()){
			   //https://login.eveonline.com/oauth/verify
			   var action = '/characters/'+character.id+'/';
			   
			   crestService.get(action).then(
			   function(eve_character) {
			   		
			        _self.account = eve_character;
			        $scope.character = _self.character;

			    });

			} //else if(character.refreshAuth()){

			//} 
			else {
				$scope.requireLogin = true;
			}


		}])
})();