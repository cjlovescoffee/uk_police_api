window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

var dt = require('datatables.net-bs4');
var Chart = require('chart.js');

/*
* Store some global variables
*/

let map = null;
let prev_infowindow = false;

/*
*  new_map
*  This function will render a Google Map onto the selected jQuery element
*  @param	$el (jQuery element)
*/

function new_map($el) {
  var $markers = $el.find('.marker');
  var args = {
    zoom: 16,
    center: new google.maps.LatLng(0, 0),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
  };
  var map = new google.maps.Map($el[0], args);
  map.markers = [];

  $markers.each(function(){
    add_marker($(this), map);
  });

  center_map(map);

  return map;
}

/*
*  add_marker
*  This function will add a marker to the selected Google Map
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*/

function add_marker( $marker, map ) {
  var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
  var marker = new google.maps.Marker({
    position: latlng,
    map: map,
    // icon: icon,
  });

  map.markers.push(marker);

  if($marker.html())
  {
    var infowindow = new google.maps.InfoWindow({
      content: $marker.html()
    });

    google.maps.event.addListener(marker, 'click', function() {
      map.setCenter(marker.getPosition());
      if(prev_infowindow) {
         prev_infowindow.close();
      }
      prev_infowindow = infowindow;
      infowindow.open( map, marker );
    });
  }
}

/*
*  center_map
*  This function will center the map, showing all markers attached to this map
*  @param	map (Google Map object)
*/

function center_map(map) {
  var bounds = new google.maps.LatLngBounds();
  $.each(map.markers, function(i, marker){
    var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
    bounds.extend(latlng);
  });

  if(map.markers.length == 1)
  {
      map.setCenter(bounds.getCenter());
      map.setZoom(16);
  }
  else
  {
    map.fitBounds( bounds );
  }
}

$(document).ready(function() {

  var header = $('body > header');
  var currentScrollPosition = $(window).scrollTop();

  $(window).on('load resize', function() {
    $(':root').css('--header-height', $('body > header').outerHeight());
  });

  $(window).scroll(_.throttle(headerHandler, 250));

  function headerHandler() {
    var updatedScrollPosition = $(window).scrollTop();
    var show = updatedScrollPosition > currentScrollPosition;
    header.toggleClass("show", !show);
    header.toggleClass("hide", show);
    currentScrollPosition = updatedScrollPosition;
  }

  $('.map').each(function(){
    map = new_map($(this));
  });

  var searches = $('#searches').DataTable();
  var total = searches.data().rows().count();
  var clothingRemoved = searches.column(8).data().filter((value) => {return value == "Yes";}).count();
  var genderMale = searches.column(4).data().filter((value) => {return value == "Male";}).count();

  var ethnicities = {
    labels: [],
    datasets: [
      {
        backgroundColor: [],
        data: [],
      }
    ]
  };

  var colors = ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"];

  searches.column(6).data().unique().each(function(value, index) {
    var uniqueValue = value;
    var count = searches.column(6).data().filter((value) => {return value == uniqueValue;}).count();
    ethnicities.labels.push(uniqueValue);
    ethnicities.datasets[0].backgroundColor.push(colors[index]);
    ethnicities.datasets[0].data.push(count);
  });

  var ethnicity = $('#ethnicity');
  var ethnicityChart = new Chart(ethnicity, {
    type: 'bar',
    data: ethnicities,
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Ethnicity Breakdown'
      }
    }
});

  var clothing = $('#clothing');
  var clothingPie = new Chart(clothing, {
      type: 'doughnut',
      data: {
        datasets: [{
            data: [clothingRemoved, (total - clothingRemoved)],
            backgroundColor: ['#343a40', '#1b4080']
        }],
        labels: ['Required', 'Not Required']
    },
    options: {
      title: {
        display: true,
        text: 'Removal Of More Than Outer Clothing'
      }
    }
  });

  var gender = $('#gender');
  var genderPie = new Chart(gender, {
      type: 'pie',
      data: {
        datasets: [{
            data: [genderMale, (total - genderMale)],
            backgroundColor: ['#343a40', '#1b4080']
        }],
        labels: ['Male', 'Female']
    },
    options: {
      title: {
        display: true,
        text: 'Gender of Stop & Search Suspects'
      }
    }
  });

});
