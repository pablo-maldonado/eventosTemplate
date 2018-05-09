function myMap() {
  var mapProp= {
    center:new google.maps.LatLng(-34.8948770197085,-56.1487440197085),
    zoom:12,
  };

  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

  google.maps.event.addListener(map, 'click', function(event) {
    geocodeLatLng(geocoder, map, infowindow, event.latLng);
  });
  var geocoder = new google.maps.Geocoder;
  var infowindow = new google.maps.InfoWindow;


}

function geocodeLatLng(geocoder, map, infowindow, inLatLng) {
 var latlng = inLatLng;
 geocoder.geocode({'location': latlng}, function(results, status) {
   if (status === 'OK') {
     if (results[1]) {
       map.setZoom(15);
       var marker = new google.maps.Marker({
         position: latlng,
         map: map
       });
       infowindow.setContent(results[0].formatted_address);
       infowindow.open(map, marker);
       map.panTo(latlng);
       showInAddress(results[0].formatted_address);
     } else {
       window.alert('No results found');
     }
   } else {
     window.alert('Geocoder failed due to: ' + status);
   }
 });
}


function showInAddress(text){
$('#event_addres').val(text);
}
