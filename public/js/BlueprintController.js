Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

(function(){
	angular.module('Eve')
		.controller("BlueprintsController",['$scope','marketService','xmlService','_','$http', '$sce', 'character','xml','images',
			function($scope,marketService,xmlService, _ , $http, $sce,character,xml,images){

			   _self = this;

			   var uniqueMaterialTypeIdList = function(){

			   		 var materialList = _.chain($scope.blueprints)
					 .pluck('materials')
					 .flatten()
					 .pluck('materialTypeID')
					 .value();

					 return _.uniq(materialList);
			   }

			   var uniqueIndustryOutputTypeIdList = function(){

					 return _.chain($scope.blueprints)
					 .pluck('tech2Invention').flatten()
					 .pluck('blueprintCreatesId')
					 .uniq()
					 .value();
			   }

			   var getMarketPrices = function(){

					 var query = 'typeid='+uniqueMaterialTypeIdList().join(',') + '&regionlimit=10000043';
					 
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

			   				bp.materials.forEach(function(m,i){
			   					m.marketPrice = _self.materialPrices[m.materialTypeID];
			   				});
			   				
			   			}
			   		)
			   }

			   var embelishWithT2 = function(t2){
			   		_.filter( $scope.blueprints, function(bp){ return bp.typeName == t2.Input})
			   		.forEach(
			   			function(bp,i){
				   			bp.tech2Invention =  bp.tech2Invention || [];
			   				bp.tech2Invention.push(t2);
			   			}
			   		);

			   }

			   var embelishWithMarketSellPrice = function( marketPrice ){
			   		
			   		var match = null;

			   		$scope.blueprints.forEach( function(bp){
		   				if(bp.blueprintCreatesId == marketPrice.data.id ){
		   					bp.InventoryMarketPrice = marketPrice;
		   				}
			   		});

			   }

			   var getBlueprintMarketPrices = function(){

					 var query = 'typeid='+uniqueIndustryOutputTypeIdList().join(',') + '&regionlimit=10000043';
					 
					 marketService.get('/marketstat?'+query)
					 .then(function(prices){
			   			var parsed = xml.parse(prices).type;
			   			parsed.forEach(function(mp,i){
			   				embelishWithMarketSellPrice(mp);
			   			})
					 });
			   }

			   var embelishWithMaterials = function(material){
			   		
			   		_.filter( $scope.blueprints, function(bp){ return bp.blueprintCopyId == material.typeID})
			   		.forEach(
			   			function(bp,i){
				   				bp.materials =  bp.materials || [];
				   				bp.materials.push(material);
			   			}
			   		);

			   }

			   var getTech2Inventions = function(){
			   		var inputList = JSON.stringify(knownBlueprints());
			   		$http.get('/blueprints/'+inputList).then(
					   	function(blueprints) {

							blueprints.forEach(function(t2,i){
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
			   
			   /*
			   *	The EVE Api doesn't return blueprints in Citadels using this list
			   *	the app uses AssetList and selects blueprints from there
			   *	but time and matrial reseach is only returned by the blueprints service
			   *
			   */
			   $scope.NpsBlueprintsWithResearch = function () {
			   	   var action = 'char/Blueprints.xml.aspx?characterId=%d&keyID=%d&vCode=%s&flat=1';
				   xmlService.get(action.format(character.id,character.api_key,character.api_vcode)).then(
				   	function(blueprints) {

				   		var parsed = xml.parse(blueprints);
				        /*TODO: 
					        Overload assetListBlueprint 
					        materialEfficiency and timeEfficiency
					        properties
				        */

				    });
				}

			    $http.get( '/blueprints?characterId=%d&keyID=%d&vCode=%s'.format(character.id,character.api_key,character.api_vcode) )
			    .then(
			    	function(blueprints) {
			    		_self.blueprints = blueprints.data;
			        	$scope.blueprints = _self.blueprints;

			        	getIndustryMaterials();
			    	}
			    );

			   var knownBlueprints = function(){

			   		var list = [];
			   		_self.blueprints.forEach(function(bp,i){
			   			list.push(parseInt(bp.blueprintCopyId));
			   		})
			   		return list;
			   }

			   var blueprintImageDefaults = function(bp,width){

			   		if(bp == undefined && _self.currentBlueprint == undefined) throw {};

			   		bp = bp || _self.currentBlueprint;
			   		bp.id = bp.id || bp.blueprintCopyId;
			   		width = width || 64;
			   		return {
			   			'blueprint': bp,
			   			'width': width
			   		}
			   }

			   $scope.blueprintImageUrl = function(bp,width){
			   		
			   		try {
			   			var opt = blueprintImageDefaults(bp,width);
			   		} catch(e){ return ''; }

			   		return images.inventoryTypeImageUrl(opt.blueprint.id, opt.width);
			   }

			   $scope.blueprintImage = function(bp,width){
			   		
			   		try {
			   			var opt = blueprintImageDefaults(bp,width);
			   		} catch(e){ return ''; }

			   		return $sce.trustAsHtml(images.imageForInventoryType(opt.blueprint.id, opt.width));

			   }

			   $scope.typeImage = function(typeId,width){
			   		return $sce.trustAsHtml(images.imageForInventoryType(typeId, width));
			   }

			   $scope.showBlueprintData = function(bp){

				    _self.currentBlueprint = bp;
					$scope.currentBlueprint = bp;

					document.body.scrollTop = document.documentElement.scrollTop = 0;

			   }

			   $scope.marketSellPriceHtml = function(bp){
			   		if(bp == undefined) return '';
			   		if(bp.materials == undefined) return '';
			   		if(bp.InventoryMarketPrice == undefined) return '';

			   		var price = parseFloat( bp.InventoryMarketPrice.sell.avg['#text'] );
			   		return $sce.trustAsHtml('' + price.formatMoney(2));
			   }

			   $scope.materialCost = function( material ){
			   		var cost = parseFloat(material.marketPrice.avg['#text']);
			   		var qty = material.quantity;

			   		return $sce.trustAsHtml('' + (cost * qty).formatMoney(2));
			   }

			   $scope.industryCost = function( bp, runs ){

			   		if(bp == undefined) return '';
			   		if(bp.materials == undefined) return '';

			   		runs = runs || 1;
			   		var marketAvg = 0.00;

			   		// 0 to 10 as a reduction is 0.9 through to 1;
			   		var materialModifier =  (100 - bp.materialEfficiency) /100;
			   		

			   		bp.materials
			   		.forEach(function(m){
			   			if(m.marketPrice == undefined) return;
			   			var baseQuantity = m.quantity;
			   			var required = Math.max(runs, Math.ceil(Math.round(runs * baseQuantity * materialModifier, 2)));

			   			marketAvg += parseFloat( m.marketPrice.avg['#text'] ) * required;
			   		});

			   		

			   		return $sce.trustAsHtml( '' + marketAvg.formatMoney(2) );
			   }

			   $scope.industryProfit = function( bp ){

			   		if(bp == undefined) return 0;
			   		if(bp.materials == undefined) return 0;
			   		if(bp.InventoryMarketPrice == undefined) return 0;
			   		var marketAvg = 0.00;
			   		console.log(bp);
			   		bp.materials
			   		.forEach(function(m){
			   			if(m.marketPrice == undefined) return;
			   			//console.log( parseFloat(mp.avg['#text']) );
			   			marketAvg += parseFloat( m.marketPrice.avg['#text'] ) * m.quantity;
			   		});

			   		sell = bp.blueprintCreatesQuantity * parseFloat(bp.InventoryMarketPrice.sell.avg['#text']);
			   		return (sell - marketAvg);
			   }

			   $scope.industryProfitHtml = function(bp){
			   	console.log(bp);
			   	var profit = $scope.industryProfit(bp);
			   	return $sce.trustAsHtml( ''+ profit.formatMoney(2) );
			   }

			   $scope.money = function(s){
			   	 return $sce.trustAsHtml( ''+parseFloat(s).formatMoney(2) );
			   }

		}])
})();