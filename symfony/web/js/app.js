var bookmarkApp = angular.module('bookmarkApp', [
	'ngRoute',
	'bookmarkController',
	'bookmarkFilters'
]);

bookmarkApp.config(['$routeProvider',
	function($routeProvider) {
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
			when('/bookmarks/:bookmarkId', {
				templateUrl: 'views/bookmark-detail.html',
				controller: 'BookmarkDetailCtrl'
			}).
			otherwise({
				redirectTo: '/categories'
			});
	}
]);