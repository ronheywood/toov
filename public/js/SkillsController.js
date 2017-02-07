(function(){

	angular.module('Eve')
		.controller("SkillsController",['$scope','_','$http', '$sce', 'character',
			function($scope, _ , $http, $sce,character){
				$scope.skills = [];
				$http.get('/character/96956057/skillqueue').then(function(resposne){
					$scope.skills = resposne.data;
				});

				$scope.completedSkills = function(){
					var now = Date();
					return _.filter( $scope.skills, function(s){ return Date(s.finishedDate) < now; }).length;

				}
				
			}
		
		])
})();