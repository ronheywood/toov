<div ng-controller="AccountController" class="fill welcome">

		<div>EVE Blueprints</div>
		<p>&nbsp;</p>
    	<div class="" ng-bind-html="characterImage(64)"></div>
    	<div class="" ng-bind="character.name"></div>
    	
    	<div>
    		<button ng-click="authenticate()">Log In</button>
    	</div>

</div>