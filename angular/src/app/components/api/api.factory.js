(function() {
  'use strict';

  // return an environment variable and url
  
  angular
    .module('madhouse')
    .factory('Api', Api);

  /** @ngInject */
  function Api($log, $http, Environment) {
    
    var ENV = Environment.apiURL;

    return {
      registerVoter: function (email) {

        return $http.post(ENV + '/register-voter', {
          email: email
        });
        
      }
      
    };
    
  }

})();