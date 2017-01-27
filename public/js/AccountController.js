(function(){
	angular.module('Eve')
	.controller("AccountController",['$scope','$cookies','crestService', '$sce', 'env', 'character','images', 
		function($scope, $cookies,crestService, $sce,env,character,images){

			var _self = this;

		   $scope.characterImage = function(width){
		   		if(_self.account==undefined) return  $sce.trustAsHtml('');
		   		return $sce.trustAsHtml(images.imageForCharacter(_self.account,width));
		   }

		   $scope.authenticate = function(){

		   		var authPath = 'https://login.eveonline.com/oauth/authorize/';
		   		var response_type = 'response_type=code';
				
				var base_server = '%s//%s'.format(window.location.protocol,window.location.host);
				var redirect_uri = 'redirect_uri='+ base_server +'/openauth';

				var client_id = 'client_id='+env.client_id;
				var scope = 'scope=publicData+characterAssetsRead+esi-assets.read_assets.v1';
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