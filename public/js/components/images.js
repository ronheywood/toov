(function(){
	angular.module('Eve')
	.factory('images',function(){

		var images = {

			imageForInventoryType : function(typeId,width){ 
				   		
		   		width = width || 64;
		   		var url = 
		   		'https://imageserver.eveonline.com/Type/%d_%d.png'.format(typeId,width);

		   		var image = '<img src="'+ url +'" />';
		   		
		   		return image;
			},

			imageForCharacter : function( character, width){

		   		if( character == undefined) return '';
		   		width = width || 64;

		   		return '<img src="'+ character.portrait[width+"x"+width].href +'" class="avatar" />';

			}

		}

		return images;		

	});

})();

			   