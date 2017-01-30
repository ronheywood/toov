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

		<div class="blueprint-table" ng-repeat="blueprint in blueprints | orderBy: industryProfit : true">
			
			<div class="panel panel-default" data-blueprint="">

				<div class="panel-header">
					<span class="label label-success pull-right" ng-show=" blueprint.quantity > 0">
						NEW
					</span>
					<span class="badge pull-right" ng-show=" blueprint.quantity == -2">
						{{blueprint.runs}} runs
					</span>
					<a class="blueprint-name" ng-click="showBlueprintData(blueprint);">
						 {{blueprint.typeName}}
						 {{blueprint.quantity == -2 ? '(copy)' : ''}}
					</a>
				</div>

				<table class="table">
					<tr>
						<th>&nbsp;</th>
						<th>Research</th>
						<th>Industry Output Value</th>
						<th>Industry Material Cost</th>
						<th>Profit</th>
						<th>
							{{ blueprint.tech2Invention.length }} 
							Invention<span ng-hide="blueprint.tech2Invention.length==1">s</span>
						</th>
					</tr>
					<tr>
						<td>
							<span ng-bind-html="blueprintImage(blueprint,64)" 
							ng-click="showBlueprintData(blueprint);"></span>
						</td>
						<td>
						{{blueprint.materialEfficiency}} /
						{{blueprint.timeEfficiency}}
						</td>

						<td>
							<span ng-bind-html="marketSellPriceHtml(blueprint)">
							</span>
							
							x {{ blueprint.blueprintCreatesQuantity }}
						</td>
						<td>
							<span ng-bind-html="industryCost(blueprint)">
							</span>
						</td>
						<td>
							<span ng-bind-html="industryProfitHtml(blueprint)">
							</span>
						</td>
						<td>
							<article ng-show="blueprint.tech2ItemId">
								
								<div class="invention" ng-repeat="invention in blueprint.tech2Invention">
								<span class="badge pull-right">{{ invention.baseProbability*100 }}%</span>
								<p>{{ invention.tech2ItemName }}</p>
								
								</div>

							</article>
							<article ng-hide="blueprint.tech2ItemId">
								No Science Inventions Available
								<div>&nbsp;</div>
							</article>
						</td>
					</tr>
				</table>
			</div>

		</div>
		</section>

</section>