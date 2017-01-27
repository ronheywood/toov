(function(){
	angular.module('Eve')
	.factory('character', ['$http','$cookies', function($http,$cookies) {

		return { 
			isAuthed : function(){
				var auth = JSON.parse($cookies.get('Auth') || null);
				if(auth == null) return false;

				var authed = new Date( (auth.startTime * 1000) + (auth.expires_in * 1000) );

				if(authed < new Date()){
					console.log('Auth expired: '+new Date(authed));
					return this.refreshAuth();
				}

				if(auth.charatcerId != undefined) {
					this.id = auth.charatcerId
				}

				this.auth = auth;
				return true;

			},
			refreshAuth : function(){
				var auth = JSON.parse($cookies.get('Auth') || null);
				if(auth == null) return false;
				//$http.post('')
				console.log(+'Refresh with '+ auth.refresh_token);
				var action = '/refreshauth';
				window.location.replace(action);
			},
			id : null,
			auth : null
		}

	}])

})();