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

		var myModule = angular.module('Eve',['ngCookies']);