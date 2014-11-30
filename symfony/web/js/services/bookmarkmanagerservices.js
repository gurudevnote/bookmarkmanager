'use strict';

/* Services */

var bookmarkServices = angular.module('bookmarkServices', ['ngResource']);

phonecatServices.factory('Category', ['$resource',
  function($resource){
    return $resource('api/v1/categories/:phoneId.json', {}, {
      query: {method:'GET', params:{phoneId:'categories'}, isArray:true}
    });
  }]);