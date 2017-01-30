<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

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

<div class="page-container" id="app" ng-app="Eve">
  
	<!-- top navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation" ng-controller="AccountController">
       <div class="container">
    	<div class="navbar-header">

           <button type="button" toggle-nav class="navbar-toggle" data-toggle="offcanvas" data-target=".sidebar-nav">
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
           </button>

           <a class="navbar-brand" href="#">Toov Corp Management</a>

           <span class="pull-right" ng-bind-html="characterImage(64)"></span>
	  	   <a class="pull-right" href="#" ng-bind="character.name"></a>

    	</div>
       </div>
    </div>
      
    <div class="container" ng-controller="AccountController">
      <div class="row row-offcanvas row-offcanvas-left">
        
        <!-- sidebar -->
        <div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
            @include('partials/side-nav')
        </div>
  	
        <!-- main area -->
        <div class="col-xs-12 col-sm-10">
	        @yield('content')
        </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->
  </div><!--/.container-->
</div><!--/.page-container-->

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
	<script type="text/javascript" src="js/SkillsController.js"></script>
	</body>
</html>