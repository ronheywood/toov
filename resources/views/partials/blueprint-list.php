<section ng-controller="BlueprintsController" class="row">

		<div class="panel panel-default col col-md-10 col-md-offset-1" ng-show="currentBlueprint">

			<div class="panel-body">

				<span ng-bind-html="blueprintImage(currentBlueprint)"></span>
				{{currentBlueprint.data.typeName}}

				<div ng-show="currentBlueprint.data.tech2Invention">

					<h3 >Invention</h3>

					<div ng-repeat="invention in currentBlueprint.data.tech2Invention">

						<span ng-bind-html="typeImage(invention.tech2ItemId,32)"></span>
						{{invention.tech2ItemName}} 
						<span class="badge">{{invention.baseProbability * 100}}%</span>
						
					</div>

				</div>

				<div>

					<h3>Industry Materials</h3>

					<table class="table">
					<tr ng-repeat="material in currentBlueprint.data.materials">

						<td>{{material.typeName}} </td>

						<td>{{material.quantity}}</td>
						
						<td>
							Unit ISK
							<span ng-bind-html="money(material.marketPrice.avg['#text'])"></span>
						</td>

						<td>
							Total ISK 
							<span ng-bind-html="materialCost(material)"></span>

						</span></td>

					</tr>
					</table>

					<strong>Unit Total</strong>
					<span ng-bind-html="industryCost(currentBlueprint)"></span>
					</div>

				</div>

		</div>

		<section>
		<div class="blueprint col col-md-3 col-sm-3 col-xs-5" ng-repeat="blueprint in blueprints | orderBy: industryProfit : true"
		>
			
			<div class="panel panel-default" data-blueprint="">
				<div class="panel-body">

					<span ng-bind-html="blueprintImage(blueprint,64)" 
					ng-click="showBlueprintData(blueprint);"></span>

					<a class="blueprint-name" ng-click="showBlueprintData(blueprint);">
						 {{blueprint.data.typeName}}
						 {{blueprint.data.quantity == -2 ? '(copy)' : ''}}
					</a>
					<span class="badge" ng-show=" blueprint.data.quantity == -2">
						{{blueprint.data.runs}} runs
					</span>

					<span class="label label-success" ng-show=" blueprint.data.quantity > 0">
						NEW
					</span>

				</div>
				<ul class="list-group">
					
					<li class="list-group-item">
					Research: {{blueprint.data.materialEfficiency}} /
					{{blueprint.data.timeEfficiency}}</li>
					<li class="list-group-item">
						
						Sell ISK
						<span ng-bind-html="marketSellPriceHtml(blueprint)">
						</span>
						
						x {{ blueprint.data.tech2Invention[0].blueprintCreatesQuantity }}
					</li>
					<li class="list-group-item">
						
						Manufacturing ISK 
						<span ng-bind-html="industryCost(blueprint)">
						</span>
					</li>
					<li class="list-group-item">
						
						Profit ISK 
						<span ng-bind-html="industryProfitHtml(blueprint)">
						</span>
					</li>

					<li class="list-group-item" ng-show="blueprint.data.tech2Invention[0].tech2ItemName">
						{{ blueprint.data.tech2Invention.length }} T2 Variant
					</li>
					<li class="list-group-item" ng-hide="blueprint.data.tech2Invention[0].tech2ItemName">
						No T2 Variant
					</li>
				</ul>
			</div>

		</div>
		</section>

</section>