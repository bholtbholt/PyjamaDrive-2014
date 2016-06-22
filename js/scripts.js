jQuery(document).ready(function($) {

  ///////////////////////////////////////////////////////
	// Mailto Anti Spam logic
	// Use: <a class="mailto" data-domain="youneeq.ca" data-prefix="info" ></a>
  ///////////////////////////////////////////////////////

  $('.mailto').each(function() {
      prefix = $(this).data('prefix');
      domain = $(this).data('domain');
      text = $(this).data('text') ? $(this).data('text') : prefix+'@'+domain;
      $(this).attr('href', 'mailto:'+prefix+'@'+domain).append(text);
  });

  ///////////////////////////////////////////////////////
  // Make Home Navigation links send users to
  // the right spot when navigation from another page
  ///////////////////////////////////////////////////////

  $('.slide-menu a').each(function() {
    link = $(this).attr('title');
    href = $(this).attr('href');
    $(this).attr('href', href+'#'+link);
  })

  ///////////////////////////////////////////////////////
  // Auto Scrolling Function
  ///////////////////////////////////////////////////////

  function autoScrollTo(link) {
    $('body,html').animate({scrollTop: $(link).position().top}, 800);
  }

  ///////////////////////////////////////////////////////
  // Scrolls to button
  // use: <button class="scoll-button" data-scroll="main-footer">CLick</button>
  ///////////////////////////////////////////////////////

  $('.scroll-button').click(function(event) {
  	link = '#'+$(this).data('scroll');
  	autoScrollTo(link);
  });

  ///////////////////////////////////////////////////////
  // Scrolls to the article from the menu
  ///////////////////////////////////////////////////////

  $('.slide-menu a').click(function(event) {
		link = '#'+$(this).attr('title');
		if ($(link).length) {
	  	event.preventDefault();
  	 	autoScrollTo(link);
  	}
  });

  ///////////////////////////////////////////////////////
  // Scroll to top button
  ///////////////////////////////////////////////////////

  $('.scroll-to-top').click(function(event) {
    autoScrollTo('body,html');
  });


  ///////////////////////////////////////////////////////
  // Geolocation
  ///////////////////////////////////////////////////////

  if ($('#locations').length) {
    $('#locations').one(loadAllLocations()); // Loads all the locations into jQuery
    $('#locations').one(getLocation()); // Finds user geolocation automatically
  }

  // Check for geolocation
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else { 
      locationMessage.html("Sorry. Geolocation is not supported by this browser.");
    }
  }

  // If Geolocation works run functions
  function showPosition(position) {
    NearestCity( position.coords.latitude, position.coords.longitude );
  }

  // If Geolocation errors occur
  function showError(error) {
    switch(error.code) {
      case error.PERMISSION_DENIED:
        locationMessage.html("You denied the request for Geolocation.")
        break;
      case error.POSITION_UNAVAILABLE:
        locationMessage.html("Location information is unavailable. Refresh to try again.")
        break;
      case error.TIMEOUT:
        locationMessage.html("The request to get your location timed out. Refresh to try again.")
        break;
      case error.UNKNOWN_ERROR:
        locationMessage.html("An unknown error occurred. Refresh to try again.")
        break;
    }
  }

  // Use Google API to Geocode user input
  function geocodeLocation() { 
    geocoder = new google.maps.Geocoder();
    locationInput = $('#locationInput').val();
    geocoder.geocode({ 'address': locationInput }, function (results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        latitude = results[0].geometry.location.lat();
        longitude = results[0].geometry.location.lng();

        NearestCity(latitude, longitude);
      } else {
        locationMessage.html("An error occurred while connecting to Google Maps. Please try again.");
      }
    });
  };

  // Enable user GeocodeLocation
  $('#locationInput').live('change', function(){
    geocodeLocation();
  });
  $('#locationSubmit').click(function(event){
    geocodeLocation();
  });


  ///////////////////////////////////////////////////////
  // Load all Locations via Ajax
  ///////////////////////////////////////////////////////

  function loadAllLocations() {
    $.ajax({
      type: 'POST',
      url: pd_scripts_vars.all_the_locations,
      data: 'id=loadAllLocations',
      dataType: 'json',
      cache: false,
      success: function(result) {
        cities = result;
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log("loadAllLocations: " + jqXHR + " :: " + textStatus + " :: " + errorThrown);
      }
    });
  }

  ///////////////////////////////////////////////////////
  // Update the Location Map
  ///////////////////////////////////////////////////////

  // Cities Array
  // array($id, $latitude, $longitude, $title, $address, $url);

  locationMap = $('#locationMap');
  locationMessage = $('#locationMessage');
  locationTitle = $('#locationTitle');
  locationAddress = $('#locationAddress');

  function updateLocation(location) {
    locationMessage.html("Here's the closest location to you:");
    title = location[5] ? '<a href="' + location[5] + '" target="_blank">' + location[3] + '</a>' : location[3] ;
    locationTitle.html(title);
    locationAddress.html(location[4]);
    locationMap.attr('src', 'https://maps.googleapis.com/maps/api/staticmap?markers=' + location[1] + ',' + location[2] + '&zoom=15&size=345x250')
  }

  ///////////////////////////////////////////////////////
  // Check for nearest city
  ///////////////////////////////////////////////////////

  function NearestCity( latitude, longitude ) {
    var mindif=99999;
    var closest;

    for (index = 0; index < cities.length; ++index) {
      var dif =  PythagorasEquirectangular( latitude, longitude, cities[ index ][ 1 ], cities[ index ][ 2 ] );
      if ( dif < mindif ) {
        closest=index;
        mindif = dif;
      }
    }
    updateLocation(cities[ closest ]);
  }

  // Convert Degress to Radians
  function Deg2Rad( deg ) {
   return deg * Math.PI / 180;
  }

  // Calculate longitude & latitude distances 
  function PythagorasEquirectangular( lat1, lon1, lat2, lon2 ) {
    lat1 = Deg2Rad(lat1);
    lat2 = Deg2Rad(lat2);
    lon1 = Deg2Rad(lon1);
    lon2 = Deg2Rad(lon2);
    var R = 6371; // radius of the earth in km
    var x = (lon2-lon1) * Math.cos((lat1+lat2)/2);
    var y = (lat2-lat1);
    var d = Math.sqrt(x*x + y*y) * R;
    return d;
  }


  ///////////////////////////////////////////////////////
	// Ajax contact form
  ///////////////////////////////////////////////////////

	$(function() {
		var form = $('#contactForm');
		var formMessages = $('#form-messages');

		$(form).submit(function(event) {
			event.preventDefault();
			var formData = $(form).serialize();

			$.ajax({  
				type: "POST",
				data: formData,
				url: pd_scripts_vars.template_path + '/snippets/forms/contactForm.php'				
			}).done(function(response) {
		    // Set the message text.
		    $(formMessages).show().text(response);

		    // Clear the form.
        formIDS = ['name', 'email', 'message'];
        for (id in formIDS) {
          $('#'+formIDS[id]).val('');
        }
		    $(formMessages).delay(2500).fadeOut();
			}).fail(function(data) {
		    // Set the message text.
		    if (data.responseText !== '') {
	        $(formMessages).text(data.responseText);
		    } else {
	        $(formMessages).text('Oops! An error occurred and your message could not be sent.');
		    }
			})
		});
	})
});