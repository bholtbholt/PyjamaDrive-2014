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
					<h1 class="h3 blog-article-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
					<div class="byline">
						<p><?php _e('Written by '); the_author_posts_link(); _e(' on '); the_time('F j, Y'); _e(' at '); the_time(); _e(' '); edit_post_link('<small>Edit this entry</small>','',''); ?></p>
					</div><!--close byline-->
					<div class="post-content">
						<?php the_content(); ?>
						<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
					</div><!--.post-content-->
					<p class="small"><?php the_category(', '); the_tags(' | ', ', ', ' '); ?></p>
				</article>

				<ul class="pager">
				  <li class="previous"><?php previous_post_link('%link', '&larr; See Older Articles') ?></li>
				  <li class="next"><?php next_post_link('%link', 'See Newer Articles &rarr;') ?></li>
				</ul>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end loop ?>
		</div><!--col-sm-8-->
		<div class="col-md-4 hidden-xs hidden-sm">
			<?php get_sidebar(); ?>
		</div>
	</div><!--row-->
</div><!--container-->

<?php get_footer(); ?>