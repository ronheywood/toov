<section ng-controller="BlueprintsController" class="bp-card row">

		<div class="panel panel-default col col-md-10 col-md-offset-1" ng-show="currentBlueprint">

			<div class="panel-body">

				<span ng-bind-html="blueprintImage(currentBlueprint)"></span>
				{{currentBlueprint.typeName}}

				<div ng-show="currentBlueprint.tech2ItemName">

					<h3 >Invention</h3>

					<div>

						<span ng-bind-html="typeImage(blueprint.tech2ItemId,32)"></span>
						{{blueprint.tech2ItemName}} 
						<span class="badge">{{blueprint.baseProbability * 100}}%</span>
						
					</div>

				</div>

				<div>

					<h3>Industry Materials</h3>

					<table class="table">
					<tr ng-repeat="material in currentBlueprint.materials">

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

		<div class="blueprint col col-lg-2 col-md-3 col-sm-3 col-xs-5 col-xs-offset-1 " ng-repeat="blueprint in blueprints | orderBy: industryProfit : true">
			
			<div class="panel panel-default" data-blueprint="">
				<div class="panel-body">

					<span ng-bind-html="blueprintImage(blueprint,64)" 
					ng-click="showBlueprintData(blueprint);"></span>

					<a class="blueprint-name" ng-click="showBlueprintData(blueprint);">
						 {{blueprint.typeName}}
						 {{blueprint.quantity == -2 ? '(copy)' : ''}}
					</a>
					<span class="badge" ng-show=" blueprint.quantity == -2">
						{{blueprint.runs}} runs
					</span>

					<span class="label label-success" ng-show=" blueprint.quantity > 0">
						NEW
					</span>

				</div>
				<ul class="list-group">
					
					<li class="list-group-item">
					Research: {{blueprint.materialEfficiency}} /
					{{blueprint.timeEfficiency}}</li>
					<li class="list-group-item">
						
						Sell ISK <br />
						<span ng-bind-html="marketSellPriceHtml(blueprint)">
						</span>
						
						x {{ blueprint.blueprintCreatesQuantity }}
					</li>
					<li class="list-group-item">
						
						Manufacturing <span>ISK</span>
						<br />
						<span ng-bind-html="industryCost(blueprint)">
						</span>
					</li>
					<li class="list-group-item">
						
						Profit ISK <br/>
						<span ng-bind-html="industryProfitHtml(blueprint)">
						</span>
					</li>

					<li class="list-group-item" ng-show="blueprint.tech2ItemId">
						{{ blueprint.tech2Invention.length }} Invention<span ng-hide="blueprint.tech2Invention.length==1">s</span>
						<div>{{ blueprint.baseProbability*100 }}% base probability of success</div>
					</li>
					<li class="list-group-item" ng-hide="blueprint.tech2ItemId">
						No Science Inventions Available
						<div>&nbsp;</div>
					</li>
				</ul>
			</div>

		</div>
		</section>

</section>