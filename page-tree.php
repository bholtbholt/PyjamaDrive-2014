<?php //Template Name: Page Tree Template
			get_header();
			if ( have_posts() ) while ( have_posts() ) : the_post();
			$templatePID = $post->ID;
			$thumbnail = wp_get_attachment_url(get_post_thumbnail_id($templatePID));
			$bg_image_options = esc_html( get_post_meta($templatePID, 'bg_image_option', true) );
			$bg_color = esc_html( get_post_meta($templatePID, 'bg_color', true) ); ?>

		<article id="<?php the_slug(); ?>" class="page-article <?php echo ($bg_color) ? $bg_color : ''?>" <?php echo ($thumbnail) ? 'style="background: url('.$thumbnail.') '.$bg_image_options.';"' : '' ?>>
			<div class="container">
				<?php the_content(); ?>
			</div>
		</article>
<?php endwhile; ?>

<?php $page_query = query_posts(array(
				'post_parent' => $templatePID,
				'post__not_in' => array( $templatePID ),
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_type' => 'page',
				'posts_per_page' => -1
			));
			if ( have_posts() ) while ( have_posts() ) : the_post();
			$thumbnail = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
			$bg_image_options = esc_html( get_post_meta($post->ID, 'bg_image_option', true) );
			$bg_color = esc_html( get_post_meta($post->ID, 'bg_color', true) ); ?>

		<article id="<?php the_slug(); ?>" class="page-article <?php echo ($bg_color) ? $bg_color : ''?>" <?php echo ($thumbnail) ? 'style="background: url('.$thumbnail.') '.$bg_image_options.';"' : '' ?>>
			<div class="container">
					<?php the_content(); ?>
			</div> <!-- close container -->
		</article>

<?php endwhile; wp_reset_postdata(); ?>

<?php get_footer(); ?>