(function(){
	angular.module('Eve')
		.controller("BlueprintsController",['$scope','xmlService','$http', '$sce', 'character','xml','images',
			function($scope, xmlService, $http, $sce,character,xml,images){

			   var action = 'char/Blueprints.xml.aspx?characterId=%d&keyID=%d&vCode=%s&flat=1';
			   _self = this;

			   var embelishWithT2 = function(t2){
					var BreakException = {};
				   	
			   		var match = $scope.blueprints.forEach(
			   			function(bp,i){
			   			if( bp.data.typeName == t2.Input ){
			   				if(bp.data.tech2Invention==undefined){
			   					bp.data.tech2Invention = [];
			   				}
			   				
			   				bp.data.tech2Invention.push(t2);
			   				//Don't break - there can be many matches,
			   				//since BP copies can't be stacked
			   			}
			   		});

			   }
			   
			   xmlService.get(action.format(character.id,character.api_key,character.api_vcode)).then(
			   	function(blueprints) {

			   		var parsed = xml.parse(blueprints);
			        _self.blueprints = parsed.rowset.row;
			        $scope.blueprints = _self.blueprints;
			        
					$scope.tech2Invention();		        

			    });

			   var knownBlueprints = function(){

			   		var list = [];
			   		_self.blueprints.forEach(function(bp,i){
			   			list.push(parseInt(bp.data.typeID));
			   		})
			   		return list;
			   }

			   $scope.tech2Invention = function(){
			   		var inputList = JSON.stringify(knownBlueprints());
			   		$http.get('/blueprints/'+inputList).then(
					   	function(blueprints) {

							blueprints.data.forEach(function(t2,i){
								embelishWithT2(t2);
							});

					    });
			   }

			   $scope.blueprintImage = function(bp,width){
			   		
			   		if(bp == undefined && _self.currentBlueprint == undefined) return '';

			   		bp = bp || _self.currentBlueprint;
			   		bp.id = bp.id || bp.data.typeID;
			   		width = width || 64;

			   		return $sce.trustAsHtml(images.imageForInventoryType(bp.id, width));
			   }

			   $scope.showBlueprintData = function(bp){

				    _self.currentBlueprint = bp;
					$scope.currentBlueprint = bp;

			   }

		}])
})();