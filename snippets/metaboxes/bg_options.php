<?php  
  // All the background colours
  $bgColors = array('', 'cream-bg', 'pink-bg', 'red-bg', 'light-green-bg', 'dark-green-bg' );

  $bg_image_option = esc_html( get_post_meta($post->ID, 'bg_image_option', true) );
  $bg_color = esc_html( get_post_meta($post->ID, 'bg_color', true) ); ?>

  <p class="meta-box-title strong">Background Color:</p>
  <div id="bg_color_box" class="<?php echo $bg_color ?>"> </div>
  <div id="bg_color_select_wrapper">
    <select id="bg_color" name="bg_color" class="full-width margin-bottom">
    <?php foreach ($bgColors as $color) : ?>
      <option value="<?php echo $color ?>" <?php echo ($color == $bg_color)? 'selected' : ''; ?>><?php echo ucfirst(substr($color, 0, -3)) ?></option>
    <?php endforeach; ?>
    </select>
  </div>


  <p class="meta-box-title radio-group">
  <label>
    <input type="radio" <?php if ($bg_image_option=="center center repeat fixed" || $bg_image_option=="") {echo "checked ";}?>name="bg_image_option" value="center center repeat fixed">Repeat Image
  </label>
  <label>
    <input type="radio"  <?php if ($bg_image_option=="center center no-repeat fixed; background-size: cover") {echo "checked ";}?>name="bg_image_option" value="center center no-repeat fixed; background-size: cover">Fill Section
  </label>
</p>



<script type="text/javascript">
// Live background swatch updating
jQuery(document).ready( function($) {
  $('#bg_color').live('change', function(){
    newColor = $(this).val();
    $('#bg_color_box').attr("class", newColor);
  });                
});    
</script>