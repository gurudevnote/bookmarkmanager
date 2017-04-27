var bookmarkApp = angular.module('bookmarkApp', [
	'ngRoute',
	'bookmarkController',
	'bookmarkFilters',
	'bookmarkServices',
	'angular-loading-bar'
]);

bookmarkApp.config(['$routeProvider', '$httpProvider',
	function($routeProvider, $httpProvider) {
		$httpProvider.defaults.cache = true;
		$routeProvider.
			when('/categories', {
				templateUrl: 'views/category-list.html',
				controller: 'CategoryListCtrl'
			}).
			when('/categories/:categoryId', {
				templateUrl: 'views/category-detail.html',
				controller: 'CategoryDetailCtrl'
			}).
			when('/bookmarks', {
				templateUrl: 'views/bookmark-list.html',
				controller: 'BookmarkListCtrl'
			}).
			when('/search/:keyword?', {
				templateUrl: 'views/bookmark-list.html',
				controller: 'BookmarkListCtrl'
			}).
			when('/bookmarks/:bookmarkId', {
				templateUrl: 'views/bookmark-detail.html',
				controller: 'BookmarkDetailCtrl'
			}).
			when('/questions', {
				templateUrl: 'views/question-list.html',
				controller: 'QuestionListCtrl'
			}).
			when('/angulars', {
				templateUrl: 'views/angulars.html',
				controller: 'AngularsCtrl'
			}).
			otherwise({
				redirectTo: '/categories'
			});
	}
])
.config(['cfpLoadingBarProvider',
	function(cfpLoadingBarProvider) {
		//cfpLoadingBarProvider.includeSpinner = false;
		cfpLoadingBarProvider.spinnerTemplate = '<div><span class="fa fa-spinner">Loading...</div>';
	}
]);

bookmarkApp.run(['$rootScope', '$location', function($rootScope, $location){
	var path = function() 
	{ 
		return $location.path();
	};

	$rootScope.$watch(path, function(newVal, oldVal){
		$rootScope.activetab = newVal;
	});
}]);