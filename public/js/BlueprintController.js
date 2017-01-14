(function(){
	angular.module('Eve')
		.controller("BlueprintsController",['$scope','marketService','xmlService','_','$http', '$sce', 'character','xml','images',
			function($scope,marketService,xmlService, _ , $http, $sce,character,xml,images){

			   var action = 'char/Blueprints.xml.aspx?characterId=%d&keyID=%d&vCode=%s&flat=1';
			   _self = this;

			   var uniqueMaterialTypeIdList = function(){

			   		 var materialList = _.chain($scope.blueprints)
			   		 .pluck('data')
					 .pluck('materials')
					 .flatten()
					 .pluck('materialTypeID')
					 .value();

					 return _.uniq(materialList);
			   }

			   var uniqueIndustryOutputTypeIdList = function(){

					 return _.chain($scope.blueprints)
					 .pluck('data')
					 .pluck('tech2Invention').flatten()
					 .pluck('blueprintCreatesId')
					 .uniq()
					 .value();
			   }

			   var getMarketPrices = function(){

					 var query = 'typeid='+uniqueMaterialTypeIdList().join(',') + '&regionlimit=10000002';
					 
					 marketService.get('/marketstat?'+query)
					 .then(function(prices){
			   				var parsed = xml.parse(prices).type;
			   				var Index = {};

			   				_.each(parsed,function(price,oi){
			   					Index[price.data.id]  = price.sell;
			   				});

			   				_self.materialPrices = Index;
			   				$scope.materialPrices = _self.materialPrices;

			   				embelishMaterialsWithMarketPrices();
					 });

			   }

			   var embelishMaterialsWithMarketPrices = function(){
			   		$scope.blueprints.forEach(
			   			function(bp){

			   				bp.data.materials.forEach(function(m,i){
			   					m.marketPrice = _self.materialPrices[m.materialTypeID];
			   				});
			   				
			   			}
			   		)
			   }

			   var embelishWithT2 = function(t2){
			   		_.filter( $scope.blueprints, function(bp){ return bp.data.typeName == t2.Input})
			   		.forEach(
			   			function(bp,i){
				   			bp.data.tech2Invention =  bp.data.tech2Invention || [];
			   				bp.data.tech2Invention.push(t2);
			   			}
			   		);

			   }

			   var embelishWithMarketSellPrice = function( marketPrice ){
			   		
			   		var match = null;

			   		$scope.blueprints.forEach( function(bp){
			   			bp.data.tech2Invention.forEach(function(i){
			   				
			   				if(i.blueprintCreatesId == marketPrice.data.id ){
			   					bp.data.InventoryMarketPrice = marketPrice;
			   				}
			   			});
			   		});

			   }

			   var getBlueprintMarketPrices = function(){

					 var query = 'typeid='+uniqueIndustryOutputTypeIdList().join(',') + '&regionlimit=10000002';
					 
					 marketService.get('/marketstat?'+query)
					 .then(function(prices){
			   			var parsed = xml.parse(prices).type;
			   			parsed.forEach(function(mp,i){
			   				embelishWithMarketSellPrice(mp);
			   			})
					 });
			   }

			   var embelishWithMaterials = function(material){
			   		
			   		_.filter( $scope.blueprints, function(bp){ return bp.data.typeID == material.typeID})
			   		.forEach(
			   			function(bp,i){
				   				bp.data.materials =  bp.data.materials || [];
				   				bp.data.materials.push(material);
			   			}
			   		);

			   }

			   var getTech2Inventions = function(){
			   		var inputList = JSON.stringify(knownBlueprints());
			   		$http.get('/blueprints/'+inputList).then(
					   	function(blueprints) {

							blueprints.data.forEach(function(t2,i){
								embelishWithT2(t2);
							});

							getBlueprintMarketPrices(); 

					    });
			   }

			   var getIndustryMaterials = function(){
			   		var inputList = JSON.stringify(knownBlueprints());
			   		$http.get('/blueprints/'+inputList+'/materials').then(
					   	function(materials) {

							materials.data.forEach(function(material,i){
								embelishWithMaterials(material);
							});

							getMarketPrices();

					    });
			   }
			   
			   xmlService.get(action.format(character.id,character.api_key,character.api_vcode)).then(
			   	function(blueprints) {

			   		var parsed = xml.parse(blueprints);
			        _self.blueprints = parsed.rowset.row;
			        $scope.blueprints = _self.blueprints;

					getIndustryMaterials();
					getTech2Inventions(); 

			    });

			   var knownBlueprints = function(){

			   		var list = [];
			   		_self.blueprints.forEach(function(bp,i){
			   			list.push(parseInt(bp.data.typeID));
			   		})
			   		return list;
			   }

			   $scope.blueprintImage = function(bp,width){
			   		
			   		if(bp == undefined && _self.currentBlueprint == undefined) return '';

			   		bp = bp || _self.currentBlueprint;
			   		bp.id = bp.id || bp.data.typeID;
			   		width = width || 64;

			   		return $sce.trustAsHtml(images.imageForInventoryType(bp.id, width));
			   }

			   $scope.typeImage = function(typeId,width){
			   		return $sce.trustAsHtml(images.imageForInventoryType(typeId, width));
			   }

			   $scope.showBlueprintData = function(bp){

				    _self.currentBlueprint = bp;
					$scope.currentBlueprint = bp;

			   }

			   $scope.industryCost = function( bp ){
			   		if(bp == undefined) return '';
			   		if(bp.data.materials == undefined) return '';

			   		var marketAvg = 0.00;

			   		bp.data.materials
			   		.forEach(function(m){
			   			if(m.materialPrice == undefined) return;
			   			//console.log( parseFloat(mp.avg['#text']) );
			   			marketAvg += parseFloat( m.marketPrice.avg['#text'] ) * m.quantity;
			   		});

			   		return $sce.trustAsHtml( '' +marketAvg );
			   }

		}])
})();