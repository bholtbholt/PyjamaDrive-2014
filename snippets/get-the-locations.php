<?php $locations = array(
							'post_type' => 'locations',
							'posts_per_page' => 1,
							'orderby' => 'title',
							'order' => 'DESC'
						 );
$locations_loop = new WP_Query( $locations );

while ( $locations_loop->have_posts() ) : $locations_loop->the_post();
	$title = get_the_title();
	$url = esc_html( get_post_meta( get_the_ID(), 'url', true ) );
	$latitude = esc_html( get_post_meta( get_the_ID(), 'latitude', true ) );
	$longitude = esc_html( get_post_meta( get_the_ID(), 'longitude', true ) );
	$address = esc_html( get_post_meta( get_the_ID(), 'address', true ) ); ?>

	<div class="row">
		<div class="col-sm-6 col-md-5">
			<img id="locationMap" class="img-rounded" src="https://maps.googleapis.com/maps/api/staticmap?markers=<?php echo $latitude.','.$longitude ?>&zoom=15&size=345x250">
		</div>
		<div class="col-sm-6 col-md-7">
			<p id="locationMessage" class="lead">Here's the drop off location closest to you:</p>
			<p id="locationTitle" class="bold">
				<?php echo $url? '<a href="'.$url.'" target="_blank">'.$title.'</a>' : $title; ?>
			</p>
			<p id="locationAddress"><?php echo $address ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6 col-md-7 col-sm-offset-6 col-md-offset-5">
			<div class="input-group" id="locationInputGroup">
				<input type="text" class="form-control" id="locationInput" name="locationInput" placeholder="Enter a location">
				<span class="input-group-btn">
        	<button class="btn btn-primary" type="button" id="locationSubmit"><span class="glyphicon glyphicon-chevron-right"></span></button>
      	</span>			
			</div>
		</div>
	</div>


<?php endwhile; wp_reset_postdata(); ?>