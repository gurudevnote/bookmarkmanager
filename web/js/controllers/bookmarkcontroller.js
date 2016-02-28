var bookmarkController = angular.module('bookmarkController', []);
bookmarkController.controller('CategoryListCtrl', function ($scope,$http) {
	$http.get('api/v1/categories.json').success(function(data) {
		$scope.datas = data;
		$scope.orderProp = 'id';
	});
});

bookmarkController.controller('CategoryDetailCtrl',['$scope', '$routeParams', '$http', function ($scope, $routeParams, $http) {
	$http.get('api/v1/categories/'+ $routeParams.categoryId + ".json").success(function(data) {
		$scope.datas = data;
		$scope.orderProp = 'id';
	});
}]);

bookmarkController.controller('BookmarkListCtrl', function ($scope,$http) {
	$http.get('api/v1/bookmarks.json').success(function(data) {
		$scope.datas = data;
		$scope.orderProp = 'id';
	});
});

bookmarkController.controller('BookmarkDetailCtrl',['$scope', '$routeParams', '$http', function ($scope, $routeParams, $http) {
	$http.get('api/v1/bookmarks/'+ $routeParams.bookmarkId + ".json").success(function(data) {
		$scope.datas = data;
		$scope.orderProp = 'id';
	});
}]);