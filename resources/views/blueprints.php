<html>
	<head>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css"/>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script type="text/javascript" src="js/app.js"></script>
	</head>
	<body>

	<div class="container" ng-app="Eve">

    	<div ng-controller="AccountController" ng-show="character" class="page-header row">

		    	<div class="col col-xs-2" ng-bind-html="characterImage(64)"></div>
		    	<div class="col col-xs-10"><h1 ng-bind="character.name"></h1></div>
		    	
    	</div>

    	<section ng-controller="BlueprintsController" class="row">

    		<div class="panel panel-default">
    				<div class="panel-heading">
    					<h2>Your Blueprints</h2>
    				</div>
	    			<div class="panel-body" ng-show="currentBlueprint">
		    			<span ng-bind-html="blueprintImage(currentBlueprint)"></span>
		    			{{currentBlueprint.data.typeName}}

		    			<div >

		    				<h3 >Materials</h3>

							<div ng-repeat="material in currentBlueprint.data.materials">

								{{material.typeName}} 
	    						<span class="badge">{{material.quantity }}</span>
								
	    						<span> 
	    							Unit ISK {{ material.marketPrice.avg['#text'] }}
	    						</span>

								<span> 
									Total ISK {{  ((material.marketPrice.avg['#text']) * material.quantity).toFixed(2) }}
								</span>

	    					</div>

	    					<strong>Unit Total</strong>
	    					<span ng-bind-html="industryCost(currentBlueprint)"></span>

	    				</div>

		    			<div ng-show="currentBlueprint.data.tech2Invention">

		    				<h3 >Invention</h3>

							<div ng-repeat="invention in currentBlueprint.data.tech2Invention">

								<span ng-bind-html="typeImage(invention.outputs,32)"></span>
	    						{{invention.Invents}} 
	    						<span class="badge">{{invention.baseProbability * 100}}%</span>
								
	    					</div>
	    				</div>
	    			</div>

	    	<table class="table table-responsive col col-md-6">
	    		<thead>
	    			<tr>
	    				<th>Name</th>
	    				<th>Material Efficency</th>
	    				<th>Time Efficency</th>
	    				<th>Industry</th>
	    				<th>Invents</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr ng-repeat="blueprint in blueprints">
	    				<td>

	    					<span ng-bind-html="blueprintImage(blueprint,32)"></span>
	    					<a ng-click="showBlueprintData(blueprint);">
	    						 {{blueprint.data.typeName}}
	    						 {{blueprint.data.quantity == -2 ? '(copy)' : ''}}
	    					</a>
	    					<span class="badge" ng-show=" blueprint.data.quantity == -2">
	    						{{blueprint.data.runs}} 
	    					</span>

	    					<span class="label label-success" ng-show=" blueprint.data.quantity > 0">
	    						NEW
	    					</span>
	    				</td>
	    				<td>{{blueprint.data.materialEfficiency}}</td>
	    				<td>{{blueprint.data.timeEfficiency}}</td>
	    				<td>
	    					<span>
	    					Sell ISK {{ blueprint.data.InventoryMarketPrice.sell.avg['#text'] }}
	    					</span>
	    					
	    					<span ng-bind="{{ blueprint.industryCost }}"></span>
	    				</td>
	    				<td>
	    					<div ng-show="blueprint.data.tech2Invention[0].tech2ItemName" 
	    						ng-repeat="invention in blueprint.data.tech2Invention">
								<span ng-bind-html="typeImage(invention.tech2ItemId,32)"></span>
	    						{{invention.tech2ItemName}} 
	    						<span class="badge">{{invention.baseProbability * 100}}%
	    						</span>
	    					</div>
	    				</td>
	    			</tr>
	    		</tbody>
	    	</table>
	    	</div>
	    </section>

	</div>

	<!-- TODO [prod] bundle these resources into a single minified resource -->

	<!-- Injector for Underscore.js functional programming helpers -->
	<script type="text/javascript" src="js/dto/underscore.js"></script>

	<!-- Facade to manage XML API and JSON API responses -->
	<script type="text/javascript" src="js/dto/xml2json.js"></script>

	<!-- Assorted Eve API service brokers -->
	<script type="text/javascript" src="js/services/crest.js"></script>
	<script type="text/javascript" src="js/services/xml.js"></script>
	<script type="text/javascript" src="js/services/market.js"></script>
	
	 <!-- Facade exposing information from the Eve static data export 
		https://eveonline-third-party-documentation.readthedocs.io/en/latest/sde/ -->
	<script type="text/javascript" src="js/services/toov.js"></script>

	<!-- Eve Entities -->
	<script type="text/javascript" src="js/components/images.js"></script>
	<script type="text/javascript" src="js/components/character.js"></script>

	<!-- ViewModel controllers -->
	<script type="text/javascript" src="js/AccountController.js"></script>	
	<script type="text/javascript" src="js/BlueprintController.js"></script>	

	</body>
</html>