<?php $latest_news = array(
							'post_type' => 'post',
							'posts_per_page' => 3,
							'orderby' => 'date'
						 );
$latest_news_loop = new WP_Query( $latest_news );
$counter = 0; ?>

<div class="row" style="margin-top:30px">

<?php while ( $latest_news_loop->have_posts() ) : $latest_news_loop->the_post();
				$counter++;
				if ($counter==1) : ?>

	<article class="blog-post col-sm-12" id="post-<?php the_ID(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('large', array('class'=>"img-responsive img-rounded post-thumbnail")); ?>
			</a>
		<?php endif ;?>
		<h2 class="h3 blog-article-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="byline">
			<p><?php _e('Written by '); the_author_posts_link(); _e(' on '); the_time('F j, Y'); _e(' at '); the_time(); _e(' '); edit_post_link('<small>Edit this entry</small>','',''); ?></p>
		</div><!--close byline-->
		<div class="post-content">
			<?php the_excerpt(); ?>
		</div><!--.post-content-->
	</article>

	<?php else : ?>

	<article class="blog-post col-sm-6" id="post-<?php the_ID(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('large', array('class'=>"img-responsive img-rounded post-thumbnail")); ?>
			</a>
		<?php endif ;?>
		<h2 class="h3 blog-article-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="byline">
			<p><?php _e('Written by '); the_author_posts_link(); _e(' on '); the_time('F j, Y'); _e(' at '); the_time(); _e(' '); edit_post_link('<small>Edit this entry</small>','',''); ?></p>
		</div><!--close byline-->
		<div class="post-content">
			<?php the_excerpt(); ?>
		</div><!--.post-content-->
	</article>

	<?php endif; ?>

<?php endwhile; wp_reset_postdata(); ?>

</div><!-- close row -->

