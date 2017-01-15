(function(){
	angular.module('Eve')
	.factory('images',function(){

		var images = {

			inventoryTypeImageUrl: function(typeId,width){

		   		width = width || 64;
		   		return 'https://imageserver.eveonline.com/Type/%d_%d.png'.format(typeId,width);

			},

			imageForInventoryType : function(typeId,width){ 
				   		
		   		width = width || 64;

		   		var image = '<img src="'+ this.inventoryTypeImageUrl(typeId,width) +'" />';
		   		
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

			   