		String.prototype.format = function() {

		    var args = Array.prototype.slice.call(arguments);
		    var rep= args.slice(0, args.length);
		    var i=0;
		    var output = this.replace(/%s|%d|%f|%@/g, function(match,idx) {
		      var subst=rep.slice(i, ++i);
		      return( subst );
		    });
		    return output;
		}

		var myModule = angular.module('Eve',['ngCookies'])
		.directive('toggleNav', [function() {
			return {
			    restrict: 'A', // E = Element, A = Attribute, C = Class, M = Comment
			    link: function($scope, iElm, iAttrs, controller) {
			      iElm.bind("click", function(){
			         angular.element(document.querySelector( '.row-offcanvas' )).toggleClass('active');
			      })
			    }
			  };
		}])
		.factory('env', [function() {
	  		
	  		var dev = {
	  			client_id: '4344fa43fd9d4114aa8823700af948c1'
	  		};

	  		var uat = {
	  			client_id: '4344fa43fd9d4114aa8823700af948c1'
	  		};

	  		var production = {
	  			client_id: ''
	  		};

	  		switch(window.location.hostname){
	  			case 'localhost':
	  				return dev;
	  			break;
	  			case 'toov.clients.ronheywood.co.uk':
	  				return uat;
	  			break;
	  		}

	  		return dev;

		}]);