var protestApp = angular.module('protestApp', ['protestMainCtrl', 'protestService', 'locationService'],
  function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
  }).run(function($rootScope) {
    $rootScope.UTIL = {
      cityState: function(city, state) {
        if (city && state) return city + ", " + state;
        return city + " " + state;
      },
      time: function(value) {
        var format = getFormat(value);
        return moment(value).format(format);
      }
    }
  });
