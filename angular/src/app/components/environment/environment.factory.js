(function() {
  'use strict';

  // return an environment variable and url
  
  angular
    .module('madhouse')
    .factory('Environment', Environment);

  /** @ngInject */
  function Environment($log) {
    
    var environment = {
      'mode':'production',
      'apiURL':'/api'
    };

    return environment;
  }

})();