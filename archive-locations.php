<?php get_header(); ?>
<article class="page-article">
	<div class="container">
		<div class="row">

<?php if ( have_posts() ) while ( have_posts() ) : the_post();
	$title = get_the_title();
	$url = esc_html( get_post_meta( get_the_ID(), 'url', true ) );
	$latitude = esc_html( get_post_meta( get_the_ID(), 'latitude', true ) );
	$longitude = esc_html( get_post_meta( get_the_ID(), 'longitude', true ) );
	$address = esc_html( get_post_meta( get_the_ID(), 'address', true ) ); ?>

			<div class="col-md-4">
				<img class="img-rounded" src="https://maps.googleapis.com/maps/api/staticmap?markers=<?php echo $latitude.','.$longitude ?>&zoom=15&size=280x250">
				<p style="margin:20px 0 0">
					<?php echo $url? '<a href="'.$url.'" target="_blank">'.$title.'</a>' : $title; ?>
				</p>
				<p><?php echo $address ?></p>
			</div>

<?php endwhile; ?>
		</div>
		<?php bootstrap_posts_nav_link(); ?>
	</div>
</article>
<?php get_footer(); ?>