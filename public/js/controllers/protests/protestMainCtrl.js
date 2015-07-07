angular.module('protestMainCtrl', [])

  .controller('protestsController', function($scope, $http, $location, Protest, Location) {
    $scope.locationData = {};
    $scope.loading = true;
    $scope.error = false;
    $scope.badLocation = true;
    $scope.noResults = true;
    $scope.url = window.apiUrl;
    $scope.offset = 0;

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

            $scope.lat = lat;
            $scope.lon = lon;

            $scope.getLocal('trending');
          }
        });
    }

    $scope.getGlobal = function(callback) {
      callback = callback || $scope.populate;
      var url = $scope.url + 'global=true&glob_limit=10&glob_offset=' + $scope.offset + '&sort=' + $scope.sort;
      Protest.get(url).success(callback);
    }

    $scope.getLocal = function(callback) {
      callback = callback || $scope.populate;
      var url = $scope.url + 'local=true&loc_limit=10&loc_offset=' + $scope.offset + '&sort=' + $scope.sort;

      Location.getLocation(function(position) {
        if(position.coords) {
          var lat = position.coords.latitude,
              lon = position.coords.longitude;
          $scope.lat = lat;
          $scope.lon = lon;
        }

        if ($scope.lat && $scope.lon)
          url += '&lat=' + $scope.lat + '&lon=' + $scope.lon;

        Protest.get(url).success(callback);
      });

    }

    $scope.changeTab = function(type, sort) {
      $scope.sort = sort || 'trending';
      $scope.resetIt();
      type == 'local' ? $scope.getLocal() : $scope.getGlobal();
      $scope.setPath(type + '/' + $scope.sort);
    }

    $scope.loadMore = function(type) {
      $scope.offset += 10;
      switch (type) {
        case 'local':
          $scope.getLocal($scope.paginate);
          break;
        case 'global':
          $scope.getGlobal($scope.paginate);
          break;
      }
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

    $scope.paginate = function(data) {
      var protests = data.protests;
      if (protests.global)
        $scope.data.global.push.apply($scope.data.global, protests.global);
      if (protests.local)
        $scope.data.local.push.apply($scope.data.local, protests.local);
    }

    $scope.resetIt = function() {
      $scope.offset = 0;
      $scope.loading = true;
      $scope.error = false;
    }

    $scope.setPath = function(path) {
      $location.path(path);
    }

    $scope.init = function() {
      var type = $location.path().split('/')[1];
      $scope.sort = $location.path().split('/')[2];
      if (type && $scope.sort) {
        switch(type) {
          case 'global':
            $('#global-tab').tab('show');
            $scope.getGlobal();
          break;

          case 'local':
            $('#local-tab').tab('show');
            $scope.getLocal();
          break;
        }
      }
      else {
        $scope.sort = 'trending';
        $scope.getGlobal();
        $scope.setPath('global/trending');
      }
    }

    $scope.init();
  });
