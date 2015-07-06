angular.module('protestMainCtrl', [])

  .controller('protestsController', function($scope, $http, $location, Protest, Location) {
    $scope.locationData = {};
    $scope.loading = true;
    $scope.error = false;
    $scope.badLocation = true;
    $scope.noResults = true;
    $scope.url = window.apiUrl;

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

            $scope.url += $.param(params);

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

    $scope.getGlobal = function(sort) {
      var url = $scope.url + 'global=true&glob_limit=10&sort=' + sort;
      $scope.resetIt();
      Protest.get(url).success($scope.populate);
    }

    $scope.getLocal = function(sort) {
      var url = $scope.url + 'local=true&loc_limit=10&sort=' + sort;
      $scope.resetIt();

      Location.getLocation(function(position) {
        if(position.coords) {
          var lat = position.coords.latitude,
              lon = position.coords.longitude;
          $scope.lat = lat;
          $scope.lon = lon;
          url += '&lat=' + lat + '&lon=' + lon;
        }
        Protest.get(url).success($scope.populate);
      });

    }

    $scope.getClass = function(page) {
      return page == $location.path() ? 'active' : '';
    }

    $scope.populate = function(data) {
      var protests = data.protests;
      $scope.loading = false;
      $scope.data = protests;
      $scope.error = data.meta.noResults || data.meta.badLocation || data.meta.noLocal;
      $scope.noResults = data.meta.noResults;
      $scope.noLocal = data.meta.noLocal;
      $scope.badLocation = data.meta.badLocation;
    }

    $scope.resetIt = function() {
      $scope.loading = true;
      $scope.error = false;
    }

    $scope.setPath = function(path) {
      $location.path(path);
    }

    $scope.init = function() {
      var type = $location.path().split('/')[1];
      var sort = $location.path().split('/')[2];
      if (type && sort) {
        switch(type) {
          case 'global':
            $('#global-tab').tab('show');
            $scope.getGlobal(sort);
          break;

          case 'local':
            $('#local-tab').tab('show');
            $scope.getLocal(sort);
          break;
        }
      }
      else {
        $scope.getGlobal('trending');
        $scope.setPath('global/trending');
      }
    }

    $scope.init();
  });
