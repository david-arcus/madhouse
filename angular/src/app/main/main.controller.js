(function() {
  'use strict';

  angular
    .module('madhouse')
    .controller('MainController', MainController);

  /** @ngInject */
  function MainController($scope, $log) {
    
//    $scope.map = { 
//      center: { 
//        latitude: -36.848461, 
//        longitude: 174.763336 
//      }, 
//      zoom: 11,
//      showKml: true
//    };
//    
//    $scope.show = true;
//    
//    var kmlUrl = 'http://madhouse.local/api/generate-kml';
//  
//    $scope.kmlLayerOptions = {
//      url: kmlUrl,
//    };
    
//    1djY-w8zV7f01Pa-KB4PV-KTfIQlqFvOv3ABTT4Fi
//   
    
      var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {lat: -36.848461, lng: 174.763336}
        });

//      var layer = new google.maps.FusionTablesLayer({
//        query: {
//          select: "price_int",
//          from: "1djY-w8zV7f01Pa-KB4PV-KTfIQlqFvOv3ABTT4Fi",
//          where: ""
//        },
//        options: {
//          styleId: 2,
//          templateId: 2
//        }
//      });
//      
//      layer.setMap(map);
    
      var ctaLayer = new google.maps.KmlLayer({
        url: 'http://madhouse-1235.appspot.com/kml/generate-kml.kmz',
        map: map
      });
    
      //ctaLayer.setMap(map);
    
    $log.debug(ctaLayer);
    
  }
})();
