<html>
	<head>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css"/>

		<link rel="stylesheet" type="text/css" href="css/app.css"/>

		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>

		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-cookies.js"></script>
		<script type="text/javascript" src="js/components/masonry.js"></script>

		<script type="text/javascript" src="js/app.js"></script>
	</head>
	<body>

	<section id="app" ng-app="Eve">

	<div class="navbar navbar-inverse navbar-fixed-left welcome-fill" ng-controller="AccountController">

	  <span class="navbar-brand" ng-bind-html="characterImage(64)"></span>
	  <a class="navbar-brand" href="#" ng-bind="character.name"></a>

	  <ul class="nav navbar-nav">
	   <li><a href="#">Blueprints</a></li>
	  </ul>

			<div id="loginModal" ng-class="requireLogin ? 'modal show' : 'ng-hide'" role="dialog" style="display: auto;">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Login with your Eve Account</h4>
			      </div>
			      <div class="modal-body">
			        <img src="https://images.contentful.com/idjq7aai9ylm/4fSjj56uD6CYwYyus4KmES/4f6385c91e6de56274d99496e6adebab/EVE_SSO_Login_Buttons_Large_Black.png?w=270&h=45" alt="Sign In" class="btn" ng-click="authenticate()"/>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>

			  </div>
			</div>

	</div>

	<div class="container">
	 @yield('content')
	</div>
	</section>

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