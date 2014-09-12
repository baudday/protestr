angular.module('protestService', [])

  .factory('Protest', function($http) {
    return {
      get: function(url) {
        return $http.get(url);
      }
    }
  });
