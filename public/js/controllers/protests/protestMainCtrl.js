angular.module('protestMainCtrl', [])

  .controller('protestsController', function($scope, $http, Protest, Location) {
    $scope.locationData = {};
    $scope.loading = true;
    $scope.error = false;
    $scope.badLocation = true;
    $scope.noResults = true;
    $scope.url = '/api/v1/protests?local=true&global=true&loc_limit=10&glob_limit=10';

    Location.getLocation(function(position) {
      if(position.coords) {
        var lat = position.coords.latitude,
            lon = position.coords.longitude;
        $scope.url += '&lat=' + lat + '&lon=' + lon;
      }

      Protest.get($scope.url)
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
      Protest.save($scope.locationData, function(coordinates, meta) {
          // Fix for zero results
          if (!meta.match) {
            $scope.$apply(function() {
              $scope.loading = false;
              $scope.error = true;
              $scope.badLocation = true;
              $scope.noResults = false;
            });
          }
          else {
            var lat = coordinates.latitude;
            var lon = coordinates.longitude;

            // Submit lat/lon to server
            var params = {
              lat: lat,
              lon: lon
            };

            $scope.url += '&' + $.param(params);

            Protest.get($scope.url)
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
