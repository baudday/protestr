angular.module('locationService', [])

  .factory('Location', function() {
    return {
      getLocation: function(callback) {
        var url = '/protests?format=json';
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(callback, callback);
        }
        else {
          callback(null);
        }
      }
    }
  });
