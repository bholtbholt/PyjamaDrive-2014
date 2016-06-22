<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-8 blog">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<article class="blog-post" id="post-<?php the_ID(); ?>">
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
				<?php endwhile;?>
				<?php bootstrap_posts_nav_link(); ?>
		</div><!--col-sm-8-->
		<div class="col-md-4 hidden-xs hidden-sm">
			<?php get_sidebar(); ?>
		</div>
	</div><!--row-->
</div><!--container-->

<?php get_footer(); ?>