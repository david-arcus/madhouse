(function() {
  'use strict';

  angular
    .module('madhouse')
    .config(config);

  /** @ngInject */
  function config($logProvider) {
    // Enable log
    $logProvider.debugEnabled(true);
    
//    uiGmapGoogleMapApiProvider.configure({
//        key: 'AIzaSyC_6Ygky0aTRIXu233uj7ilcvfOJzm-f0Q',
//        // v: '3.22', //defaults to latest 3.X anyhow
//        libraries: 'weather,geometry,visualization'
//    });

    
  }

})();
