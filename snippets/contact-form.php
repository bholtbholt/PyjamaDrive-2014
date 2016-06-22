<?php $contact_email = get_post_meta( get_page_by_title('Contact')->ID, 'email', true );
			$site_title = get_bloginfo('name'); ?>

<form id="contactForm" role="form" method="post" action="<?php echo get_template_directory_uri() . '/snippets/forms/contactForm.php' ?>">
	<div class="row">
		<div class="form-group col-sm-6">
			<label class="sr-only" for="name">Your Name</label>
			<input type="text" class="form-control" id="name" name="name" required placeholder="Your Name">
		</div>
		<div class="form-group col-sm-6">
			<label class="sr-only" for="email">Your Email Address</label>
			<input type="email" class="form-control" id="email" name="email" required placeholder="Your Email Address">
		</div>
	</div>
	<div class="form-group">
		<label class="sr-only" for="message">Your Message</label>
		<textarea class="form-control" rows="6" id="message" name="message" required placeholder="Your Message"></textarea>
	</div>
	<input type="hidden" name="site_title" value="<?php echo $site_title ?>">
	<input type="hidden" name="contact_email" value="<?php echo $contact_email ?>">
	<div class="form-group pull-right">
		<button type="submit" id="submit" class="btn btn-primary">Send Your Message</button>
	</div>
	<div id="form-messages"></div>
</form>