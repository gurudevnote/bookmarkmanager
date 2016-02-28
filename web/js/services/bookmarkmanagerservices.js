'use strict';

/* Services */

var bookmarkServices = angular.module('bookmarkServices', ['ngResource']);

bookmarkServices.factory('Category', ['$resource',
  function($resource){
    return $resource('api/v1/categories/:categoryId.json', {categoryId : '@id'});
}]);