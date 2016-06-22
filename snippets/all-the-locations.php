<?php 

define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php');

$json_locations = array();

$locations = array(
							'post_type' => 'locations',
							'posts_per_page' => -1,
							'orderby' => 'title',
							'order' => 'ASC'
						 );
$locations_loop = new WP_Query( $locations );

while ( $locations_loop->have_posts() ) : $locations_loop->the_post();
	$id = get_the_ID();
	$title = get_the_title();
	$url = esc_html( get_post_meta( get_the_ID(), 'url', true ) );
	$address = esc_html( get_post_meta( get_the_ID(), 'address', true ) );
	$latitude = esc_html( get_post_meta( get_the_ID(), 'latitude', true ) );
	$longitude = esc_html( get_post_meta( get_the_ID(), 'longitude', true ) );
			
	$json_locations[] = array($id, $latitude, $longitude, $title, $address, $url);

endwhile;
wp_reset_postdata();

echo json_encode($json_locations);

?>