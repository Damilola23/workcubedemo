



function initMap() {


  var myLatLng = {lat: 6.4938576, lng: 3.381396900000027};
  var qubeLatLng = {lat: 6.4940413, lng: 3.381431799999973};



    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);

         
    }

 
function showPosition(position) {
    myLatLng = {lat:  position.coords.latitude, lng: position.coords.longitude};
}

  var map = new google.maps.Map(document.getElementById('startupmap'), {
    zoom: 6,
    center: myLatLng
  });
var infowindow = new google.maps.InfoWindow();
 var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Techpoint.ng'
        });
  var marke2 = new google.maps.Marker({
          position: qubeLatLng,
          map: map,
          title: 'Iqube Labs'
        });

var map_data = $('#map-data').data("longlat");
// console.log(map_data.length);
// console.log(map_data);
var marker=[];
var contents = [];
var infowindows = [];
  for (i = 0; i< map_data.length;i++) {

    var locate = map_data[i].location;
    var myjson = locate;
    // console.log(myjson);
    function isJson(item) {
      item = typeof item !== "string"
      ? JSON.stringify(item)
      : item;

      try {
        item = JSON.parse(item);
      } catch (e) {
        return false;
      }

      if (typeof item === "object" && item !== null) {
        return true;
      }

      return false;
      }

      if(isJson(myjson)){
        if(JSON.parse(myjson).latitude !== undefined && JSON.parse(myjson).longitude !== undefined && JSON.parse(myjson).longitude.length>1 && JSON.parse(myjson).latitude.length>1)
        {
          var lati = JSON.parse(myjson).latitude;
          var longi = JSON.parse(myjson).longitude;
        var myLatLng = {lat: parseFloat(lati), lng: parseFloat(longi)};
        //console.log(JSON.parse(myjson).latitude);


  
        marker[i] = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title:map_data[i].name,
          url: '/companies/view/'+map_data[i].id
        });
        
        marker[i].index = i;
        contents[i] = '<a href="/companies/view/'+map_data[i].id+'"><div class="trend-head"><h3 style="font-size:12px;">'+map_data[i].name+'<h3><p style="font-size:10px;">'+map_data[i].short_description+'</p></div></a>';

  infowindows[i] = new google.maps.InfoWindow({
    content: contents[i]
  });


        marker[i].addListener('mouseover', function() {
    infowindows[this.index].open(map, marker[i]);
  });
            marker[i].addListener('mouseout', function() {
    infowindows[this.index].close();
  });
      
         google.maps.event.addListener(marker[i], 'click', function() {
        window.location.href = this.url;
    });

        }
           

      }


   
  }


}
