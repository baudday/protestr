angular.module('protestService', [])

  .factory('Protest', function($http) {
    return {
      get: function(url) {
        return $http.get(url);
      },

      save: function(data, callback) {
        var geocoder = new google.maps.Geocoder();
        var address = data.address;
        geocoder.geocode({ 'address': address }, callback);
      }
    }
  });
