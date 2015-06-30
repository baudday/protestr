angular.module('protestMainCtrl', [])

  .controller('protestsController', function($scope, $http, Protest, Location) {
    $scope.locationData = {};
    $scope.loading = true;
    $scope.error = false;
    $scope.badLocation = true;
    $scope.noResults = true;

    Location.getLocation(function(position) {
      var url = '/protests?format=json';
      if(position.coords) {
        var lat = position.coords.latitude,
            lon = position.coords.longitude;
        url += '&lat=' + lat + '&lon=' + lon;
      }

      Protest.get(url)
        .success(function(data) {
          var protests = data.protests;
          $scope.loading = false;
          $scope.data = protests;
          $scope.error = data.meta.noResults || data.meta.badLocation || data.meta.noLocal;
          $scope.noResults = data.meta.noResults;
          $scope.noLocal = data.meta.noLocal;
          $scope.badLocation = data.meta.badLocation;
        });
    });

    $scope.submitLocation = function() {
      $scope.loading = true;
      $scope.error = false;
      $scope.badLocation = true;
      $scope.noResults = true;

      // Geocode input
      Protest.save($scope.locationData, function(results, status) {
          // Fix for zero results
          if (status === 'ZERO_RESULTS') {
            $scope.$apply(function() {
              $scope.loading = false;
              $scope.error = true;
              $scope.badLocation = true;
              $scope.noResults = false;
            });
          }
          else {
            var lat = results[0].geometry.location.A;
            var lon = results[0].geometry.location.F;

            // Submit lat/lon to server
            var params = {
              lat: lat,
              lon: lon
            };

            var url = '/protests?format=json&' + $.param(params);

            Protest.get(url)
              .success(function(data) {
                var protests = data.protests;
                $scope.loading = false;
                $scope.data = protests;
                $scope.error = data.meta.noResults || data.meta.badLocation || data.meta.noLocal;
                $scope.noResults = data.meta.noResults;
                $scope.noLocal = data.meta.noLocal;
                $scope.badLocation = data.meta.badLocation;
              });
          }
        });
    }
  });
