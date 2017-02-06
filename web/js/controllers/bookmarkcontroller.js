var bookmarkController = angular.module('bookmarkController', []);
bookmarkController.controller('CategoryListCtrl', ['$scope', 'Category', function ($scope, Category) {
	$scope.categories = Category.query();
	$scope.orderProp = 'id';
}]);

bookmarkController.controller('CategoryDetailCtrl',['$scope', '$routeParams', 'Category', function ($scope, $routeParams, Category) {
	$scope.category = Category.get({categoryId: $routeParams.categoryId });
	$scope.orderProp = 'id';
}]);

bookmarkController.controller('BookmarkListCtrl', function ($scope, $http, $routeParams) {
	var keyword = $routeParams.keyword || '';
	$http.get('api/v1/bookmarks.json?keyword=' + keyword ).success(function(data) {
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