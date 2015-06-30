angular.module('locationService', [])

  .factory('Location', function() {
    return {
      getLocation: function(callback) {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(callback, callback);
        }
        else {
          callback(null);
        }
      }
    }
  });
