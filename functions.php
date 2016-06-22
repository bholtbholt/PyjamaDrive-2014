<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');

// Customize the Admin Pages
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');
function my_admin_theme_style() {
  wp_enqueue_style('my-admin-theme', get_template_directory_uri() . '/css/wp-admin.css');
}

// post thumbnail support
add_theme_support( 'post-thumbnails' );

// custom menu support
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'header-menu' => 'Header Menu',
      'footer-menu' => 'Footer Menu'
		)
	);
}

// enables wigitized sidebars
if ( function_exists('register_sidebar') )

// Sidebar Widget
// Location: the sidebar
register_sidebar(array('name'=>'Blog Sidebar',
  'before_widget' => '<ul class="blog-sidebar-ul">',
  'after_widget' => '</ul>',
  'before_title' => '<h5 class="blog-sidebar-heading">',
  'after_title' => '</h5>'
));

// removes detailed login error information for security
add_filter('login_errors',create_function('$a', "return null;"));

// custom excerpt ellipses for 2.9+
add_filter('excerpt_more', 'custom_excerpt_more');
function custom_excerpt_more($more) {
  global $post;
  return '&hellip; <a href="'.get_permalink($post->ID).'" class="read-more">'.'read more &rarr;'.'</a>';
}

// Use Bootstrap pager formatting for nav links
function bootstrap_get_posts_nav_link( $args = array() ) {
	global $wp_query;
	$return = '';

	if ( !is_singular() ) {
		$defaults = array(
			'prelabel' => __('&larr; Previous Page'),
			'nxtlabel' => __('Next Page &rarr;'),
		);
		$args = wp_parse_args( $args, $defaults );
		$max_num_pages = $wp_query->max_num_pages;
		$paged = get_query_var('paged');

		if ( $max_num_pages > 1 ) {
			$return = '<ul class="pager"><li class="previous">';
			$return .= get_previous_posts_link($args['prelabel']);
			$return .= '</li><li class="next">';
			$return .= get_next_posts_link($args['nxtlabel']);
			$return .= '</li></ul>';
		}
	}
	return $return;
}
function bootstrap_posts_nav_link( $prelabel = '', $nxtlabel = '' ) {
	$args = array_filter( compact('prelabel', 'nxtlabel') );
	echo bootstrap_get_posts_nav_link($args);
}

// get the slug
function the_slug($echo=true){
	global $post;
	$slug = $post->post_name;
  if( $echo ) echo $slug;
  return $slug;
}

// Remove <br> from wpautop
//Author: Simon Battersby http://www.simonbattersby.com/blog/plugin-to-stop-wordpress-adding-br-tags/
function better_wpautop($pee){
	return wpautop($pee,false);
}
remove_filter( 'the_content', 'wpautop');
add_filter( 'the_content', 'better_wpautop');
add_filter( 'the_content', 'shortcode_unautop');

//Send Yoast to the bottom
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');
function yoasttobottom() {
  return 'low';
}

///////////////////////////////////////////////////////////////
// Shortcodes - Bootstrap /////////////////////////////////////
///////////////////////////////////////////////////////////////

// Bootstrap row
add_shortcode( 'row', 'bootstrap_row' );
add_shortcode( 'nested_row', 'bootstrap_row' );
function bootstrap_row( $atts, $content = null ) {
  $a = shortcode_atts( array('class' => '',), $atts );
  return '<div class="row ' . esc_attr($a['class']) . '">'. do_shortcode($content) . '</div>';
}

// full_col column
add_shortcode( 'full_col', 'bootstrap_full_col' );
function bootstrap_full_col( $atts, $content = null ) {
  $a = shortcode_atts( array('class' => '',), $atts );
  return '<div class="col-sm-12 ' . esc_attr($a['class']) . '">'. do_shortcode($content) . '</div>';
}

// half_col column
add_shortcode( 'half_col', 'bootstrap_half_col' );
function bootstrap_half_col( $atts, $content = null ) {
  $a = shortcode_atts( array('class' => '',), $atts );
  return '<div class="col-sm-6 ' . esc_attr($a['class']) . '">'. do_shortcode($content) . '</div>';
}

// two_third_col column
add_shortcode( 'two_third_col', 'bootstrap_two_third_col' );
function bootstrap_two_third_col( $atts, $content = null ) {
  $a = shortcode_atts( array('class' => '',), $atts );
  return '<div class="col-sm-8 ' . esc_attr($a['class']) . '">'. do_shortcode($content) . '</div>';
}

// one_third column
add_shortcode( 'one_third_col', 'bootstrap_one_third_col' );
function bootstrap_one_third_col( $atts, $content = null ) {
  $a = shortcode_atts( array('class' => '',), $atts );
  return '<div class="col-sm-4 ' . esc_attr($a['class']) . '">'. do_shortcode($content) . '</div>';
}

// quarter_width column
add_shortcode( 'quarter_col', 'bootstrap_quarter_col' );
function bootstrap_quarter_col( $atts, $content = null ) {
  $a = shortcode_atts( array('class' => '',), $atts );
  return '<div class="col-sm-3 ' . esc_attr($a['class']) . '">'. do_shortcode($content) . '</div>';
}

// quarter_width column
add_shortcode( 'three_quarter_col', 'bootstrap_three_quarter_col' );
function bootstrap_three_quarter_col( $atts, $content = null ) {
  $a = shortcode_atts( array('class' => '',), $atts );
  return '<div class="col-sm-9 ' . esc_attr($a['class']) . '">'. do_shortcode($content) . '</div>';
}

// Bootstrap misc col
add_shortcode( 'bootstrap_col', 'bootstrap_misc_col' );
function bootstrap_misc_col( $atts, $content = null ) {
  $a = shortcode_atts( array('class' => '',), $atts );
  return '<div class="' . esc_attr($a['class']) . '">'. do_shortcode($content) . '</div>';
}

// Bootstrap lead paragraph
add_shortcode( 'lead', 'bootstrap_lead_paragraph' );
function bootstrap_lead_paragraph( $atts, $content = null ) {
  $a = shortcode_atts( array('class' => '',), $atts );
  return '<p class="lead ' . esc_attr($a['class']) . '">'. do_shortcode($content) . '</p>';
}

// Bootstrap Button
// [button label="Submit"]
add_shortcode('button', 'bootstrap_button');
function bootstrap_button( $atts ) {
  $a = shortcode_atts( array('label' => 'Submit','class' => ''), $atts );
  return '<button class="btn btn-primary '. esc_attr($a['class']) .'">'. esc_attr($a['label']) .'</button>';
}

// Scroll Button
// Scrolls to ID defined in the scroll arg
// [scroll_button label="Submit" scroll="main-footer"]
add_shortcode('scroll_button', 'bootstrap_scroll_button');
function bootstrap_scroll_button( $atts ) {
  $a = shortcode_atts( array('label' => 'Submit','scroll' => 'home','class' => ''), $atts );
  return '<button class="scroll-button btn btn-primary '. esc_attr($a['class']) .'" data-scroll="'. esc_attr($a['scroll']) .'">'. esc_attr($a['label']) .'</button>';
}

///////////////////////////////////////////////////////////////
// Shortcodes /////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

// Colour Text span [text_color color="charcoal"][/text_color]
add_shortcode( 'text_color', 'pd_text_color_span' );
function pd_text_color_span( $atts, $content = null ) {
	$a = shortcode_atts( array('color' => 'red',), $atts );
  return '<span class="' . esc_attr($a['color']) . '">'. do_shortcode($content) . '</span>';
}

// Contact Form
add_shortcode('get_contact_form', 'pd_contact_form');
function pd_contact_form(){
  ob_start();  
  include('snippets/contact-form.php'); 
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;
}

// Get the Locations
add_shortcode('get_the_locations', 'pd_get_the_locations');
function pd_get_the_locations() {
  ob_start();  
  include('snippets/get-the-locations.php'); 
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;
}

// Get the Latest News
add_shortcode('get_the_latest_news', 'pd_get_the_latest_news');
function pd_get_the_latest_news() {
  ob_start();  
  include('snippets/get-the-latest-news.php'); 
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;
}

// PJ Drive Logo
add_shortcode('pj_logo', 'pd_pj_logo');
function pd_pj_logo() {
  return '<img src="'. get_template_directory_uri() . '/images/icons/PJ-Logo.svg" class="pj-logo">';
}

/////////////////////////////////////////////////////
// Contact Meta Box /////////////////////////////////
/////////////////////////////////////////////////////

// Contact Information Meta Box /////////////////////
add_action('add_meta_boxes', 'pd_contact_info_meta_box');
function pd_contact_info_meta_box() {
  global $post;
  if ( $post->ID == get_page_by_title('Contact')->ID) {
    add_meta_box('contact_information_meta_box', 'Contact Information', 'pd_contact_meta_box_formatting', 'page', 'normal');
  }
}

// Format the Contact Information Meta Box
function pd_contact_meta_box_formatting($post){
  // Add an nonce field so we can check for it later.
  wp_nonce_field('contact_information_meta_box', 'contact_information_meta_box_nonce'); ?>

  <div class="meta-inline">
    <p class="meta-box-title">Contact Form Recipient Email:</p>
    <input type="text" class="meta-box-input full-width" name="email" value="<?php echo esc_html( get_post_meta( $post->ID, 'email', true )) ?>" />
  </div>
  <div style="clear:both"></div>

  <?  // Open up PHP again 
}

// Save Contact Information Meta Box
add_action('save_post', 'pd_contact_info_meta_box_save_data');
function pd_contact_info_meta_box_save_data($post_id) {
  global $post;
  // Check if our nonce is set.
  if ( !isset( $_POST['contact_information_meta_box_nonce'] ) ) { return; }
  // Verify that the nonce is valid.
  if ( !wp_verify_nonce( $_POST['contact_information_meta_box_nonce'], 'contact_information_meta_box' ) ) { return; }
  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

  if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

  // Check for Meta Value
  if (isset($_POST['email'])) {
    $custom_type_meta_values['email'] = $_POST['email'];
  }


  // Finally ready to save the data
  if (isset($custom_type_meta_values)) {
    foreach ($custom_type_meta_values as $key => $value) {
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
        update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
        add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }

}

////////////////////////////////////////////////////
// Background Options
////////////////////////////////////////////////////

// Rename the Featured Image box to Background Image
add_action( 'do_meta_boxes', 'rename_image_box' );
function rename_image_box() {
  remove_meta_box( 'postimagediv', 'page', 'side' );
  add_meta_box( 'postimagediv', __( 'Background Image' ), 'post_thumbnail_meta_box', 'page', 'side', 'low' );
}

// Background Options Meta Box /////////////////////
add_action('add_meta_boxes', 'pd_bg_meta_box');
function pd_bg_meta_box() {
  add_meta_box('bg_meta_box', 'Background Options', 'pd_bg_meta_box_formatting', 'page', 'side', 'low');
}

// Format the Options Meta Box
function pd_bg_meta_box_formatting($post){
  wp_nonce_field('bg_meta_box', 'bg_meta_box_nonce');
  include('snippets/metaboxes/bg_options.php');
}

// Save Background Options Meta Box
add_action('save_post', 'pd_bg_meta_box_save_data');
function pd_bg_meta_box_save_data($post_id) {
  global $post;
  // Check if our nonce is set.
  if ( !isset( $_POST['bg_meta_box_nonce'] ) ) { return; }
  // Verify that the nonce is valid.
  if ( !wp_verify_nonce( $_POST['bg_meta_box_nonce'], 'bg_meta_box' ) ) { return; }
  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

  if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

  // Check for Meta Value
  $metaValues = array('bg_color', 'bg_image_option');
  foreach ($metaValues as $metaValue) {
    if (isset($_POST[$metaValue])) {
      $custom_type_meta_values[$metaValue] = $_POST[$metaValue];
    }
  }

  // Finally ready to save the data
  if (isset($custom_type_meta_values)) {
    foreach ($custom_type_meta_values as $key => $value) {
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
        update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
        add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }

}


////////////////////////////////////////////////////
// Locations Custom Post Type //////////////////////
////////////////////////////////////////////////////

add_action( 'init', 'pd_locations_custom_type' );
function pd_locations_custom_type() {
  $labels = array(
    'name'               => 'Locations',
    'singular_name'      => 'Location',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Location',
    'edit_item'          => 'Edit Location',
    'new_item'           => 'New Location',
    'all_items'          => 'All Locations',
    'view_item'          => 'View Location',
    'search_items'       => 'Search Locations',
    'not_found'          => 'No Locations found',
    'not_found_in_trash' => 'No Locations found in the Trash',
    'menu_name'          => 'Locations'
  );
  $args = array(
    'labels'        => $labels,
    'public'        => true,
    'menu_position' => 20,
    'supports'      => array( 'title' ),
    'menu_icon' => 'dashicons-admin-site',
    'exclude_from_search' => true,
    'query_var' => true,
    'register_meta_box_cb' => 'locations_meta_box',
    'has_archive'   => true
  );
  register_post_type( 'locations', $args ); 
}

add_action('add_meta_boxes', 'locations_meta_box');
function locations_meta_box() {
  add_meta_box('locations_meta_box', 'Location Information', 'locations_meta_box_formatting', 'locations', 'normal', 'low');
}

// Format the Locations Information Meta Box
function locations_meta_box_formatting($post){
  // Add an nonce field so we can check for it later.
  wp_nonce_field('locations_meta_box', 'locations_meta_box_nonce');
  include('snippets/metaboxes/location.php');
}

// Save the Metabox Data
add_action('save_post', 'pd_save_location_meta_box');
function pd_save_location_meta_box($post_id) {
  if (isset($_POST['hidden_flag'])) {
    global $post;
    // Check if our nonce is set.
    if ( !isset( $_POST['locations_meta_box_nonce'] ) ) { return; }
    // Verify that the nonce is valid.
    if ( !wp_verify_nonce( $_POST['locations_meta_box_nonce'], 'locations_meta_box' ) ) { return; }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

    if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

    // Check for Meta Value
    $metaValues = array('address', 'url', 'latitude', 'longitude');
    foreach ($metaValues as $metaValue) {
      if (isset($_POST[$metaValue])) {
        $custom_type_meta_values[$metaValue] = $_POST[$metaValue];
      }
    }

    // Finally ready to save the data
    if (isset($custom_type_meta_values)) {
      foreach ($custom_type_meta_values as $key => $value) {
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
          update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
          add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
      }
    }
  }
}



////////////////////////////////////////////////////
// Load scripts ////////////////////////////////////
////////////////////////////////////////////////////

add_action('wp_enqueue_scripts','pd_scripts_init');
function pd_scripts_init() {
	wp_enqueue_script( 'jquery' );

  wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js');
  wp_enqueue_script('bootstrap');

  wp_register_script( 'modernizr', get_template_directory_uri() . '/js/webshim/modernizr-custom.js', array( 'jquery') );
  wp_enqueue_script( 'modernizr' );

  wp_register_script( 'webshim', get_template_directory_uri() . '/js/webshim/polyfiller.js', array( 'jquery', 'modernizr' ) );
  wp_enqueue_script( 'webshim' );

  wp_register_script( 'webshim_init', get_template_directory_uri() . '/js/webshim_init.js');
  wp_enqueue_script('webshim_init');

  wp_register_script( 'google_apis', 'http://maps.googleapis.com/maps/api/js?sensor=false' );
  wp_enqueue_script('google_apis');

  wp_register_script( 'pd_scripts', get_template_directory_uri() . '/js/scripts.js');
  wp_enqueue_script('pd_scripts');

  wp_localize_script('pd_scripts', 'pd_scripts_vars', array(
      'template_path' => get_bloginfo('template_directory'),
      'all_the_locations' => get_bloginfo('template_directory') . '/snippets/all-the-locations.php'
    )
  );
}

add_action('admin_enqueue_scripts', 'pd_admin_scripts');
function pd_admin_scripts() {
  wp_register_script( 'modernizr', get_template_directory_uri() . '/js/webshim/modernizr-custom.js', array( 'jquery') );
  wp_enqueue_script( 'modernizr' );

  wp_register_script( 'webshim', get_template_directory_uri() . '/js/webshim/polyfiller.js', array( 'jquery', 'modernizr' ) );
  wp_enqueue_script( 'webshim' );

  wp_register_script( 'webshim_init', get_template_directory_uri() . '/js/webshim_init.js');
  wp_enqueue_script('webshim_init');
}
