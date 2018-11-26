@extends('layouts.members_page')
@section('content')

<div class="container-fluid">


  <div id="map"></div>
  <script>
    function initMap() {
      var uluru = {lat: 14.5965711, lng: 120.944802};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: uluru
      });


      var infowindow = new google.maps.InfoWindow({
        content: '<h4>Chocolate</h4><p><img src="http://picebucket.storage.googleapis.com/dti.png" alt="Smiley face" height="100" width="100">This is a port</p>'
      });

      var marker = new google.maps.Marker({
        icon: 'https://www.seaoil.com.ph/files/large/7fa389e51f2deda4800782a9eb8c62a0.png',
        position: uluru,
        map: map
      });

      marker.addListener('click', function() {
       infowindow.open(map, marker);
     });

    }
  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBf_e_VHl5towchvRLRWgNFHAadpJFp4hw&callback=initMap">
</script>
</div>
<style>
#map {
  height: 600px;
  width: 100%;
}
</style>


</div>

@stop
