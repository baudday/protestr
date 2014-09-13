angular.module('protestMainCtrl', [])

  .controller('protestsController', function($scope, $http, Protest, Location) {
    $scope.locationData = {};
    $scope.loading = true;
    $scope.error = false;
    $scope.badLocation = false;
    $scope.noResults = false;

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
        })
        .error(function(data) {
          $scope.loading = false;
          $scope.error = true;
        });
    });

    $scope.submitLocation = function() {
      $scope.loading = true;
      $scope.error = false;
      $scope.badLocation = false;
      $scope.noResults = false;

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
            var lat = results[0].geometry.location.k;
            var lon = results[0].geometry.location.B;

            // Submit lat/lon to server
            var params = {
              lat: lat,
              lon: lon
            };

            var url = '/protests?format=json&' + $.param(params);

            Protest.get(url)
              .success(function(data) {
                if (!data.top) {
                  $scope.loading = false;
                  $scope.error = true;
                  $scope.noResults = true;
                  $scope.badLocation = false;
                }
                else {
                  $scope.data = {
                    top: data.top,
                    cols: [
                      data.protests.splice(0, Math.ceil(data.protests.length / 2)),
                      data.protests
                    ]
                  };
                  $scope.loading = false;
                }
              })
              .error(function(data) {
                $scope.loading = false;
                $scope.error = true;
              });
          }
        });
    }
  });
