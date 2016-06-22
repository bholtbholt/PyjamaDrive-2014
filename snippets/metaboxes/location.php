<?php $address = esc_html( get_post_meta( $post->ID, 'address', true ) );
			$url = esc_html( get_post_meta( $post->ID, 'url', true ) );
			$latitude = esc_html( get_post_meta( $post->ID, 'latitude', true ) );
			$longitude = esc_html( get_post_meta( $post->ID, 'longitude', true ) );
?>

<input type="hidden" name="hidden_flag" value="true" />
<input type="hidden" id="geoLat" name="latitude" value="<?php echo $latitude ?>" />
<input type="hidden" id="geoLng" name="longitude" value="<?php echo $longitude ?>" />

<div class="half-column">
	<p class="meta-box-title">
		Address: 
		<em class="small pull-right">
			<?php echo '<span id="latitude">'. $latitude . '</span>
								  <span id="longitude">' . $longitude . '</span>' ?>
		</em>
	 </p>
	<input type="text" class="meta-box-input full-width" id="address" name="address" value="<?php echo $address ?>" />
</div>
<div class="half-column">
	<p class="meta-box-title">URL:</p>
	<input type="text" class="meta-box-input full-width" name="url" value="<?php echo $url ?>" />
</div>
<div style="clear:both"></div>

<?php // Live adjustment of geocoordinates ?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
jQuery(document).ready( function($) {
  $('#address').live('change', function(){
    GetLocation();
  });

	function GetLocation() {
    geocoder = new google.maps.Geocoder();
    address = $('#address').val();
    geocoder.geocode({ 'address': address }, function (results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        latitude = results[0].geometry.location.lat();
        longitude = results[0].geometry.location.lng();

        $('#latitude').html(latitude);
        $('#longitude').html(longitude);
        $("#geoLat").val(latitude);
        $("#geoLng").val(longitude);
      } else {
        $('#latitude').html("");
        $('#longitude').html("An error occurred");
      }
    });
  };

});    
</script>