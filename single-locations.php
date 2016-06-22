<?php get_header();

if ( have_posts() ) while ( have_posts() ) : the_post();
	$title = get_the_title();
	$url = esc_html( get_post_meta( get_the_ID(), 'url', true ) );
	$latitude = esc_html( get_post_meta( get_the_ID(), 'latitude', true ) );
	$longitude = esc_html( get_post_meta( get_the_ID(), 'longitude', true ) );
	$address = esc_html( get_post_meta( get_the_ID(), 'address', true ) ); ?>

<article class="page-article">
	<div class="container">
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
	</div>
</article>


<?php endwhile;
			get_footer(); ?>