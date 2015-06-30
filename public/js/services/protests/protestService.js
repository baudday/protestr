angular.module('protestService', [])

  .factory('Protest', function($http) {
    return {
      get: function(url) {
        return $http.get(url);
      },

      save: function(data, callback) {
        var url = 'api/v1/geocode?address=' + encodeURIComponent(data.address);
        $http.get(url).success(function(response, status) {
          callback(response.coordinates, response.meta);
        });
      }
    }
  });
