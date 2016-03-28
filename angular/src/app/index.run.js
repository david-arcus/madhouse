(function() {
  'use strict';

  angular
    .module('madhouse')
    .run(runBlock);

  /** @ngInject */
  function runBlock($log) {

    $log.debug('runBlock end');
  }

})();
