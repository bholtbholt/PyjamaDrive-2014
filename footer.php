<footer id="main-footer">
	<div class="container">
		<div class="row">

			<div class="col-sm-6 col-sm-push-6">
				<div id="likebox-wrapper">
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FThe.Christmas.Pyjama.Drive&amp;width&amp;height=395&amp;colorscheme=light&amp;show_faces=false&amp;header=false&amp;stream=true&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:395px;" allowTransparency="true"></iframe>
				</div> <!-- close likebox-wrapper -->
			</div> <!-- close col-sm-6 -->

			<div class="col-sm-6 col-sm-pull-6">
				<div class="row footer-menu-div">
					<div class="col-sm-6">
						<?php wp_nav_menu( array( 'theme_location' => 'header-menu',
			                              'container' => '',
			                              'menu_class' => 'footer-menu'
					   ) ); ?>
					</div>
					<div class="col-sm-6">
						<?php if (has_nav_menu('footer-menu')) {
										wp_nav_menu( array( 'theme_location' => 'footer-menu',
							                              'container' => '',
							                              'menu_class' => 'footer-menu'
									   ) );
									 } ?>
					</div>
				</div> <!-- close footer-menu-div -->

				<p>Brand design by<br><a href="http://www.kennedyanderson.ca" target="_blank">Kennedy Anderson Creative Group</a></p>
      	<p>Site design & development by<br><a href="http://www.brianholt.ca" target="_blank">Brian Holt</a></p>
      	<p>&copy; <?php echo date("Y") ?> All rights reserved.</p>
      	
			</div> <!-- close col-sm-6-->
		</div><!-- close row -->
	</div><!--close .container-->
</footer>

<?php wp_footer(); ?>
</body>
</html>