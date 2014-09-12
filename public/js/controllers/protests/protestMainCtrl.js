angular.module('protestMainCtrl', [])

  .controller('protestsController', function($scope, $http, Protest, Location) {
    $scope.loading = true;

    Location.getLocation(function(position) {
      var url = '/protests?format=json';
      if(position.coords) {
        var lat = position.coords.latitude,
            lon = position.coords.longitude;
        url += '&lat=' + lat + '&lon=' + lon;
      }

      Protest.get(url)
        .success(function(data) {
          $scope.data = {
            top: data.top,
            cols: [
              data.protests.splice(0, Math.ceil(data.protests.length / 2)),
              data.protests
            ]
          };
          $scope.loading = false;
        });
    });
  });
