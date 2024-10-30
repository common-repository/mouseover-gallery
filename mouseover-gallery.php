<?php

/*

Plugin Name: Mouseover Gallery
Plugin URI: http://internetdienste-berlin.de
Description: Mouseover gallery divids the content into a left_part and right_part (classes) where the thumbs are put into the right_part and the enlargments comes via mouseover the thumbs in the left_part.
Version: 1.2.3
Author: Dietrich Koch (based on Daniel Sachs)
Author URI: http://internetdienste-berlin.de
License: GPL

*/
define('MOGallery_VERSION', '1.2.1');
add_action('admin_menu', 'mo_control_menu');
/**/
add_action('wp_print_scripts','mo_reloaded_gallery_js');
add_action('wp_head','mo_helper_js',50);
register_activation_hook( __FILE__, 'mo_activate' );
register_deactivation_hook( __FILE__, 'mo_deactivate' );
function mo_reloaded_gallery_js(){	
if(!is_admin()){
	// wp_enqueue_script ('jquery');	Wird ausgeblendet, damit das eingebettete jQuery 1.4.2 arbeiten kann
    wp_enqueue_script ('thickbox');
	wp_enqueue_script ('mo_gallery_reloaded_pack', '/' . PLUGINDIR . '/mouseover-gallery/mouseover-gallery.js'
	// , array('jquery')Wird ausgeblendet, damit das eingebettete jQuery 1.4.2 arbeiten kann
	);
}
}

function mo_helper_js () {
$mo_bookmark_add=get_option('mo_bookmark');
$mo_next_click_add=get_option('mo_next_click');
	?>
	<script type='text/javascript'>
/*<![CDATA[*/
jQuery(document).ready(function() {
    jQuery('.main_image a').attr({class: "thickbox", rel: "thickbox"});

});
/*]]>*/
</script>
<?php
require_once ( dirname(__FILE__) . '/mouseover-gallery-style.php');
}
function mo_reloaded_gallery_shortcode($attr) {
  $mo_main_height=get_option('mo_main_height');
  $mo_main_width=get_option('mo_main_width');
  $mo_thumb_height=get_option('mo_thumb_height');
  $mo_thumb_width=get_option('mo_thumb_width');
  $mo_slide=get_option('mo_slide');
  $mo_border_color=get_option('mo_border_color');
  $mo_background_color=get_option('mo_background_color');
  $mo_caption_color=get_option('mo_caption_color');
  $mo_fwd_back_position=get_option('mo_fwd_back_position');
  $mo_fwd_back_add=get_option('mo_fwd_back');
  $mo_fwd_back_ini = '<div class="clear" style="clear: both;"></div><p class="gallery-nav"><a class="back" href="#" onclick="jQuery.mo_gallery_reloaded.prev(); return false;">&laquo; Back</a>    <a class="forward" href="#" onclick="jQuery.mo_gallery_reloaded.next(); return false;">Forward &raquo;</a></p>';
global $post;
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	extract(shortcode_atts(array(
		'orderby' => 'menu_order ASC, ID ASC',
		'id' => $post->ID,
		'itemtag' => 'dl',
		'icontag' => 'dt',
		'captiontag' => 'dd',
		'columns' => 3,
		'size' => 'thumbnail',
	), $attr));

        $count = 1;
	$id = intval($id);
	$attachments = get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby={$orderby}");

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link($id, $size, true) . "\n";
		return $output;
	}
	$listtag = tag_escape($listtag);
	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;

// The Gallery init
	$output = apply_filters('gallery_style', "<div class='mo-gbackgr'>");


	if($mo_fwd_back_position == 'top') {
	if($mo_fwd_back_add == 'true') {
	$output .= $mo_fwd_back_ini; 
	};
	};
if ($mo_slide == 'bottom') {
		$output .= "\n<div class='main_image'></div>\n";
	};
 $output .= "\n<div class='gholder'><ul class='gallery-thumbs mo_gallery_reloaded'>\n";
 		
	foreach ( $attachments as $id => $attachment ) {
	    $pageId = $attachment->post_parent;
        $pagetitle = get_page($pageId)->post_title;
		$a_img = wp_get_attachment_url($id);
		$att_page = get_attachment_link($id);
		$img = wp_get_attachment_image_src($id, $size);
		$img = $img[0];
		$title = $attachment->post_excerpt;

		if($title == '') $title = $attachment->post_title;
if($count == 1)
$output .= "<li class='active'>";
if($count > 1)
$output .= "<li>";
		$link = $a_img;
			$output .= "\t<a href=\"$link\" title=\"$title\" class=\"$a_class\" rel=\"$a_rel\">";
		
		$output .= "<img src=\"$img\" alt=\"$title\" class=\"thumb\"/>";
		
		$output .= "<div class=\"wrapper\">  <span class=\"caption\"> $title  </span></div>";
			$output .= "</a>"; 
		$output .= "</li>
";
$count++;
	}
	$output .= "\n</ul></div>\n";
	if ($mo_slide == 'top') {
		$output .= "<div class='main_image'><span class=\"caption\"> $pagetitle </span>
</div>\n";
	};
	if($mo_fwd_back_position == 'bottom') {
	if($mo_fwd_back_add == 'true') {
	$output .= $mo_fwd_back_ini; 
	};
	};
    $output .= "\n</div><div style='clear:both;' class='clear'></div>\n";
	return $output;
}
// Replaces the default gallery
	remove_shortcode(gallerymo);
	add_shortcode('gallerymo', 'mo_reloaded_gallery_shortcode');
//Options Page
function mo_activate()
{
  mo_set_default_options();
}
function mo_deactivate()
{
  mo_delete_options(); 
}
function mo_set_default_options() {
  if(get_option('mo_main_width')===false)		                add_option('mo_main_width', 600);
  if(get_option('mo_main_height')===false)		                add_option('mo_main_height', 480);
  if(get_option('mo_thumb_width')===false)		                add_option('mo_thumb_width', 80);
  if(get_option('mo_thumb_height')===false)		                add_option('mo_thumb_height', 80);
  if(get_option('mo_slide')===false)		                        add_option('mo_slide', 'top');
  if(get_option('mo_border_color')===false)		                add_option('mo_border_color', '000000');
  if(get_option('mo_background_color')===false)		            add_option('mo_background_color', '000000');
  if(get_option('mo_caption_color')===false)		                add_option('mo_caption_color', '887777');
  if(get_option('mo_bookmark')===false)		                    add_option('mo_bookmark', 'false');
  if(get_option('mo_next_click')===false)		                add_option('mo_next_click', 'true');
  if(get_option('mo_fwd_back')===false)		                    add_option('mo_fwd_back', 'true');
  if(get_option('mo_fwd_back_position')===false)		            add_option('mo_fwd_back_position', 'bottom');
}
function mo_delete_options() {
	delete_option('mo_main_width');
	delete_option('mo_main_height');
	delete_option('mo_thumb_width');
	delete_option('mo_thumb_height');
	delete_option('mo_slide');
	delete_option('mo_border_color');
	delete_option('mo_background_color');
	delete_option('mo_caption_color');
	delete_option('mo_bookmark');
	delete_option('mo_next_click');
	delete_option('mo_fwd_back');
	delete_option('mo_fwd_back_position');
}
function mo_control_menu() {
  $page = add_options_page('MOGallery Settings', 'MOGallery', 9, 'mo_gallery_reloaded_options', 'mo_reloaded_gallery_options');
  add_action( 'admin_print_scripts', 'mo_admin_head' ); 
}
function mo_admin_head() {
	wp_enqueue_script ('jquery');
	wp_enqueue_script ('mo_picker', '/' . PLUGINDIR . '/mouseover-gallery/picker/colorpicker.js', array('jquery'));
}

function mo_reloaded_gallery_options() {
	$hidden_field_name = 'mo_submit_hidden';
	
	$mo_main_width_name = 'mo_main_width';
	$mo_main_height_name = 'mo_main_height';
	$mo_thumb_width_name = 'mo_thumb_width';
	$mo_thumb_height_name = 'mo_thumb_height';
	$mo_slide_name = 'mo_slide';
	$mo_border_color_name = 'mo_border_color';
	$mo_background_color_name = 'mo_background_color';
	$mo_caption_color_name = 'mo_caption_color';
	$mo_bookmark_name = 'mo_bookmark';
	$mo_next_click_name = 'mo_next_click';
	$mo_fwd_back_name = 'mo_fwd_back';
	$mo_fwd_back_position_name = 'mo_fwd_back_position';
	
	$mo_main_width_val = get_option($mo_main_width_name);
	$mo_main_height_val = get_option($mo_main_height_name);
	$mo_thumb_width_val = get_option($mo_thumb_width_name);
	$mo_thumb_height_val = get_option($mo_thumb_height_name);
	$mo_slide_val = get_option($mo_slide_name);
	$mo_border_color_val = get_option($mo_border_color_name);
	$mo_background_color_val = get_option($mo_background_color_name);
	$mo_caption_color_val = get_option($mo_caption_color_name);
	$mo_bookmark_val = get_option($mo_bookmark_name);
	$mo_next_click_val = get_option($mo_next_click_name);
	$mo_fwd_back_val = get_option($mo_fwd_back_name);
	$mo_fwd_back_position_val = get_option($mo_fwd_back_position_name);
	
	if( $_POST[ $hidden_field_name ] == 'Y' ) {
		
		$mo_main_width_val = $_POST[$mo_main_width_name];
		$mo_main_height_val = $_POST[$mo_main_height_name];
		$mo_thumb_width_val = $_POST[$mo_thumb_width_name];
		$mo_thumb_height_val = $_POST[$mo_thumb_height_name];
		$mo_slide_val = $_POST[$mo_slide_name];
		$mo_border_color_val = $_POST[$mo_border_color_name];
		$mo_background_color_val = $_POST[$mo_background_color_name];
		$mo_caption_color_val = $_POST[$mo_caption_color_name];
		$mo_bookmark_val = $_POST[$mo_bookmark_name];
		$mo_next_click_val = $_POST[$mo_next_click_name];
		$mo_fwd_back_val = $_POST[$mo_fwd_back_name];
		$mo_fwd_back_position_val = $_POST[$mo_fwd_back_position_name];
		
		update_option($mo_main_width_name, $mo_main_width_val);
		update_option($mo_main_height_name, $mo_main_height_val);
		update_option($mo_thumb_width_name, $mo_thumb_width_val);
		update_option($mo_thumb_height_name, $mo_thumb_height_val);
		update_option($mo_slide_name, $mo_slide_val);
		update_option($mo_border_color_name, $mo_border_color_val);
		update_option($mo_background_color_name, $mo_background_color_val);
		update_option($mo_caption_color_name, $mo_caption_color_val);
		update_option($mo_bookmark_name, $mo_bookmark_val);
		update_option($mo_next_click_name, $mo_next_click_val);
		update_option($mo_fwd_back_name, $mo_fwd_back_val);
		update_option($mo_fwd_back_position_name, $mo_fwd_back_position_val);
		
		echo '<div class="updated"><p><strong>Options saved.</strong></p></div>';
	}
	$plugin_directory = mo_get_plugin_root();
?>
<div class="wrap">
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo bloginfo( 'url' ) . '/wp-content/plugins/mouseover-gallery/picker/colorpicker.css'; ?>" />
<!-- <script type="text/javascript">
jQuery(document).ready(function() {
jQuery('#color1, #color2, #color3').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		jQuery(el).val(hex);
		jQuery(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		jQuery(this).ColorPickerSetColor(this.value);
	}
})
.bind('keyup', function(){
	jQuery(this).ColorPickerSetColor(this.value);
});
						   		});
</script> -->
  <h2>Gallery Reloaded</h2>
  <form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
  <table class="form-table">
  <tr valign="top"><th scope="row"><h3>Setup</h3></th></tr>
      <tr valign="top">
      <th scope="row">Gallery Width</th>
        <td><input type="text" name="<?php echo $mo_main_width_name; ?>" value="<?php echo $mo_main_width_val; ?>" size="4">
          pixels </td>
      </tr>
      <tr valign="top">
      <th scope="row">Main Image Height</th>
        <td><input type="text" name="<?php echo $mo_main_height_name; ?>" value="<?php echo $mo_main_height_val; ?>" size="4">
          pixels </td>
      </tr>
      <tr valign="top">
      <th scope="row">Thumbnail Width</th>
        <td><input type="text" name="<?php echo $mo_thumb_width_name; ?>" value="<?php echo $mo_thumb_width_val; ?>" size="4">
          pixels </td>
      </tr>
      <tr valign="top">
      <th scope="row">Thumbnail Height</th>
        <td><input type="text" name="<?php echo $mo_thumb_height_name; ?>" value="<?php echo $mo_thumb_height_val; ?>" size="4">
          pixels </td>
      </tr>
     <tr valign="top">
        <th scope="row">Slideshow Position</th>
        <td>
          <select name="<?php echo $mo_slide_name; ?>" value="<?php echo $mo_slide_val; ?>">
            <option value="top" <?php if($mo_slide_val=='top'){echo 'selected="selected"';} ?>>Top</option>
            <option value="bottom" <?php if($mo_slide_val=='bottom'){echo 'selected="selected"';} ?>>Bottom</option>
          </select></td>
      </tr>
      <tr valign="top"><th scope="row"><h3>Colors</h3></th><td><h4>Click on the color field to choose your own</h4></td></tr>
      <tr valign="top">
      <th scope="row">Gallery Border Color</th>
        <td><input type="text" id="color1" name="<?php echo $mo_border_color_name; ?>" value="<?php echo $mo_border_color_val; ?>" size="6"></td>
      </tr>
      <tr valign="top">
      <th scope="row">Gallery Background Color</th>
        <td><input type="text" id="color2" name="<?php echo $mo_background_color_name; ?>" value="<?php echo $mo_background_color_val; ?>" size="6"></td>
      </tr>
      <tr valign="top">
      <th scope="row">Text Color (caption and tooltips)</th>
        <td><input type="text" id="color3" name="<?php echo $mo_caption_color_name; ?>" value="<?php echo $mo_caption_color_val; ?>" size="6"></td>
      </tr>
      <tr valign="top"><th scope="row"><h3>Controls</h3></th></tr>
      
      <tr valign="top">
        <th scope="row">Browser "Back" support</th>
        <td>Enable browser "Back / Forward" and bookmarking specific image capabilities<br />
          <select name="<?php echo $mo_bookmark_name; ?>" value="<?php echo $mo_bookmark_val; ?>">
            <option value="true" <?php if($mo_bookmark_val=='true'){echo 'selected="selected"';} ?>>Active</option>
            <option value="false" <?php if($mo_bookmark_val=='false'){echo 'selected="selected"';} ?>>Not Active</option>
          </select></td>
      </tr>
      <tr valign="top">
        <th scope="row">Main Image "Next" click</th>
        <td>Enables click on the main image to step forward<br />
          <select name="<?php echo $mo_next_click_name; ?>" value="<?php echo $mo_next_click_val; ?>">
            <option value="true" <?php if($mo_next_click_val=='true'){echo 'selected="selected"';} ?>>Active</option>
            <option value="false" <?php if($mo_next_click_val=='false'){echo 'selected="selected"';} ?>>Not Active</option>
          </select></td>
      </tr>
      <tr valign="top">
        <th scope="row">Gallery Forward / Back Buttons</th>
        <td>Enables the Galley navigation buttons<br />
          <select name="<?php echo $mo_fwd_back_name; ?>" value="<?php echo $mo_fwd_back_val; ?>">
            <option value="true" <?php if($mo_fwd_back_val=='true'){echo 'selected="selected"';} ?>>Active</option>
            <option value="false" <?php if($mo_fwd_back_val=='false'){echo 'selected="selected"';} ?>>Not Active</option>
          </select>
          <select name="<?php echo $mo_fwd_back_position_name; ?>" value="<?php echo $mo_fwd_back_position_val; ?>">
            <option value="top" <?php if($mo_fwd_back_position_val=='top'){echo 'selected="selected"';} ?>>Top</option>
            <option value="bottom" <?php if($mo_fwd_back_position_val=='bottom'){echo 'selected="selected"';} ?>>Bottom</option>
          </select>
          </td>
      </tr>
      </table>
    <hr />
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'mo_trans_domain' ) ?>" />
    </p>
  </form>
</div>
<?php
 
}

function mo_get_plugin_root() {
	return dirname(__FILE__).'/';
}
function mo_get_plugin_web_root(){
	$site_url = get_option('siteurl');

	$pos = strpos_nth(3, $site_url, '/');
	$plugin_root = mo_get_plugin_root();
	$plugin_dir_name = substr($plugin_root, strrpos(substr($plugin_root, 0, strlen($plugin_root)-2), DIRECTORY_SEPARATOR)+1); //-2 to skip the trailing '/' on $plugin_root
	if($pos===false)
		$web_root = substr($site_url, strlen($site_url));
	else
		$web_root = '/' . substr($site_url, $pos);
	if($web_root[strlen($web_root)-1]!='/')
		$web_root .= '/';
	$web_root .= 'wp-content/plugins/' . $plugin_dir_name;
	return $web_root;
}
?>
<?php
// Get the Images from the default Gallery
function mo_get_gallery_images( $args = array() ) {
	$defaults = array(
		'custom_key' => array( 'Thumbnail', 'thumbnail' ),
		'post_id' => false,
		'attachment' => true,
		'default_size' => 'thumbnail',
		'default_image' => false,
		'order_of_image' => 1,
		'link_to_post' => true,
		'image_class' => false,
		'image_scan' => false,
		'width' => false,
		'height' => false,
		'format' => 'img',
		'echo' => true
	);
	$args = apply_filters( 'mo_get_gallery_images_args', $args );
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	if ( !is_array( $custom_key ) ) :
		$custom_key = str_replace( ' ', '', $custom_key) ;
		$custom_key = str_replace( array( '+' ), ',', $custom_key );
		$custom_key = explode( ',', $custom_key );
		$args['custom_key'] = $custom_key;
	endif;
	if ( $custom_key && $custom_key !== 'false' && $custom_key !== '0' )
		$image = image_by_custom_field( $args );
	if ( !$image && $attachment && $attachment !== 'false' && $attachment !== '0' )
		$image = image_by_attachment( $args );
	if ( !$image && $image_scan )
		$image = image_by_scan( $args );
	if (!$image && $default_image )
		$image = image_by_default( $args );
	if ( $image )
		$image = display_the_image( $args, $image );
	$image = apply_filters( 'mo_get_gallery_images', $image );
	if ( $echo && $echo !== 'false' && $echo !== '0' && $format !== 'array' )
		echo $image;
	else
		return $image;
}
?>