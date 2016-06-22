<div id="comments-wrapper">
	<!-- Prevents loading the file directly -->
	<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>
	    <?php die('Please do not load this page directly or we will hunt you down. Thanks and have a great day!'); ?>
	<?php endif; ?>
	
	<!-- Password Required -->
	<?php if(!empty($post->post_password)) : ?>
	    <?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
	    <?php endif; ?>
	<?php endif; ?>
	
	
	<?php if(comments_open()) : ?>
		<div id="comments-form">
			<?php if(get_option('comment_registration') && !$user_ID) : ?>
				<p><?php _e('Our apologies, you must be '); ?><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in'); ?></a><?php _e(' to post a comment.'); ?></p><?php else : ?>
				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
					<?php if($user_ID) : ?>
						<p><?php _e('Logged in as '); ?><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"><?php _e('Log out'); ?></a></p>
						<?php else : ?>
							<div class="form-group">
								<label class="sr-only" for="author">Name</label>
								<input placeholder="Name" class="form-control" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" />
							</div>
							<div class="form-group">
								<label class="sr-only" for="email">E-Mail</label>
								<input placeholder="E-Mail" class="form-control" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" />
							</div>
							<div class="form-group">
								<label class="sr-only" for="url">Website</label>
								<input placeholder="Website" class="form-control" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" />
							</div>
						<?php endif; ?>
							<div class="form-group">
								<label class="sr-only" for="comment">Comments</label>
								<textarea placeholder="Add your comment" class="form-control" name="comment" id="comment" rows="8"></textarea>
							</div>
							<div class="form-group">
								<button type="submit" id="submit" class="btn btn-yellow">Submit Comment</button>
								<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
							</div>
				         <?php do_action('comment_form', $post->ID); ?>
			     </form>
    </div><!--#commentsForm-->
			<?php endif; ?>
		<?php else : ?>
			<?php if($comments) { echo '<p>The comments are closed.</p>';}; ?>
		<?php endif; ?>

	<?php $i = 0; $i++; ?> <!-- variable for alternating comment styles -->
	<?php if($comments) : ?>
	<div class="comments">
		<h3 class="comments-title"><?php comments_number('No comments', 'Comments', 'Comments'); ?></h3>
	    <ul class="comment-list">
	    <?php foreach($comments as $comment) : ?>
	    	<?php $comment_type = get_comment_type(); ?> <!-- checks for comment type -->
	    	<?php if($comment_type == 'comment') { ?> <!-- outputs only comments -->
		        <li id="comment-<?php comment_ID(); ?>" class="comment">
		            <?php if ($comment->comment_approved == '0') : ?> <!-- if comment is awaiting approval -->
		              <p class="waiting-for-approval"><em>Your comment is awaiting approval.</em></p>
		            <?php endif; ?>
		            <div class="comment-text">
		            	<p class="comment-author"><?php comment_author_link(); ?>&nbsp;</p>
			            <?php comment_text(); ?>
		            </div><!--.commentText-->
		            <p class="comment-meta">
		            	<?php comment_date(); ?> at <?php comment_time();  _e(' '); edit_comment_link('Edit'); ?>
		            </p>
		        </li>
			<?php } else { $trackback = true; } ?>
	    <?php endforeach; ?>
	    </ul>
	  </div>
	<?php endif; ?>
</div><!--#comments-wrapper-->