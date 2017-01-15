<html>
	<head>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css"/>

		<link rel="stylesheet" type="text/css" href="css/app.css"/>

		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>

		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.1.1/masonry.pkgd.min.js"></script>
		<script type="text/javascript" src="js/components/masonry.js"></script>

		<script type="text/javascript" src="js/app.js"></script>
	</head>
	<body>

    <div id="app" ng-app="Eve" class="row">
    	<div class="col col-md-2 col-sm-2 hidden-xs fill welcome-fill">&nbsp</div>
    	<div id="side-nav" class="col col-md-2 col-sm-2 hidden-xs fill">
            @include('partials/side-nav')
        </div>
        
		<div class="fill col col-md-10 col-sm-10 col-xs-10">
            @yield('content')
        </div>
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