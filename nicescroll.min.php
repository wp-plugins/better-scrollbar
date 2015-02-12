<?php
/*
Plugin Name: custom scroll Bar
Plugin URI: http://www.bestebazar.com/pluging/
Description: This plugin will add scroll effect for your wordpress website. 
Author: md sohel
Author URI: http://www.bestebazar.com/
Version: 1.0
*/


/*add latest jquery in wordpress*/
function ms_nicescroll_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'ms_nicescroll_jquery');


/* Adding Plugin custm CSS file */
function ms_scripts_method() {
	define('DEWDROP_SCROLLBAR_WP', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

	wp_enqueue_script('ms-nicescroll_bar-min', DEWDROP_SCROLLBAR_WP . 'js/jquery.nicescroll.min.js', array('jquery'));
	wp_enqueue_style('ms-nicescroll-css', DEWDROP_SCROLLBAR_WP . 'css/nicescroll.css');
}

add_action( 'wp_enqueue_scripts', 'ms_scripts_method' );


function ms_nicescroll_active() { ?>

<?php global $msscroll_options; $automaticpageload_settings = get_option( 'msscroll_options', $msscroll_options ); ?>
	
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var nice = $("html").niceScroll({
				cursorcolor: "<?php echo $automaticpageload_settings['cursor_color']; ?>",
				background: "<?php echo $automaticpageload_settings['cursor_background_color']; ?>",
				cursorwidth : "<?php echo $automaticpageload_settings['cursor_width']; ?>",
				cursorborderradius   : "<?php echo $automaticpageload_settings['cursor_border_radius']; ?>",
				boxzoom    : true,
			cursorborder: "<?php echo $automaticpageload_settings['cursor_border_width'].' solid '.$automaticpageload_settings['cursor_border_color']; ?>",
				scrollspeed   : "<?php echo $automaticpageload_settings['scroll_speed']; ?>",
			autohidemode: <?php echo $automaticpageload_settings['auto_hide_mode']; ?>,
			});
		});
	</script>

<?php
}
add_action('wp_head', 'ms_nicescroll_active');

// Store layouts views in array

// Store layouts views in array
$auto_hide_mode = array(
	'auto_hide_yes' => array(
		'value' => 'true',
		'label' => 'Enable auto hide'
	),
	'auto_hide_no' => array(
		'value' => 'false',
		'label' => 'Disable auto hide'
	)
);



function ms_nicescroll_options_framwrork()
{
	add_options_page('Scroll Bar Options', 'Scroll Bar Options', 'manage_options', 'automaticpageload-settings', 'msscroll_options_framwrork');
}
add_action('admin_menu', 'ms_nicescroll_options_framwrork');




add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
   define('DEWDROP_SCROLLBAR_WP', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
	
	wp_enqueue_script( 'wp-color-picker' );
	// load the minified version of custom script
	wp_enqueue_script( 'my-color-field', plugins_url( 'js/javascript.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), false, true );
	wp_enqueue_style( 'wp-color-picker' );
}


// Default options values
$msscroll_options = array(
	'cursor_color' => '#8E91DF',
	'cursor_width' => '15px',
	'cursor_border_width' => '0px',
	'cursor_border_radius ' => '0px',
	'auto_hide_mode' => 'false',
	'cursor_border_width' => '0px',
	'cursor_border_color' => '#0066CC',
	'cursor_background_color' => '',
	'scroll_speed' => '60',
	'cursor_opacitymax' => '1',
	'cursor_opacitymin' => '1'
);


if ( is_admin() ) : // Load only if we are viewing an admin page



function automaticpageload_register_settings() {
	// Register settings and call sanitation function
	register_setting( 'automaticpageload_p_options', 'msscroll_options', 'automaticpageload_validate_options' );
}

add_action( 'admin_init', 'automaticpageload_register_settings' );


// Function to generate options page
function msscroll_options_framwrork() {
	global $msscroll_options,$auto_hide_mode;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	
	<h2>Automatic Scroll Bar Options</h2>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	
	<?php $settings = get_option( 'msscroll_options', $msscroll_options ); ?>
	
	<?php settings_fields( 'automaticpageload_p_options' ); 
	
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>

	
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		<tr valign="top">
			<th scope="row"><label for="cursor_color">scrollbar color</label></th>
			<td>
				<input id="cursor_color" type="text" name="msscroll_options[cursor_color]" value="<?php echo stripslashes($settings['cursor_color']); ?>" class="color-field" /><p class="description">Select scrollbar color here. You can also add html HEX control color.</p>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><label for="cursor_background_color">scrollbar cursor background</label></th>
			<td>
				<input id="cursor_background_color" type="text" name="msscroll_options[cursor_background_color]" value="<?php echo stripslashes($settings['cursor_background_color']); ?>" class="color-field" /><p class="description">Change your scrollbar  background color. You can also add html HEX color code. Default color is none</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cursor_width">scrollbar width</label></th>
			<td>
				<input id="cursor_width" type="text" name="msscroll_options[cursor_width]" value="<?php echo stripslashes($settings['cursor_width']); ?>" class="color-field" /><p class="description">Select scrollbar width here. You can also add html HEX control width.</p>
			</td>
		</tr>
			
		
		
		<tr valign="top">
			<th scope="row"><label for="cursor_border_width">scrollbar cursor border size</label></th>
			<td>
				<input id="cursor_border_width" type="text" name="msscroll_options[cursor_border_width]" value="<?php echo stripslashes($settings['cursor_border_width']); ?>" class="my-color-field" /><p class="description">Enter scrollbar border width. Default is 0 (pixel).</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cursor_border_color">scrollbar cursor border color</label></th>
			<td>
				<input id="cursor_border_color" type="text" name="msscroll_options[cursor_border_color]" value="<?php echo stripslashes($settings['cursor_border_color']); ?>" class="my-color-field" /><p class="description">Change your scrollbar border color. Default is #0066CC.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cursor_border_radius">scrollbar border radius</label></th>
			<td>
				<input id="cursor_border_radius" type="text" name="msscroll_options[cursor_border_radius]" value="<?php echo stripslashes($settings['cursor_border_radius']); ?>" class="color-field" /><p class="description">Select scrollbar border radius here. please use border radius.example:5px.</p>
			</td>
		</tr>
				
			
		
		<tr valign="top">
			<th scope="row"><label for="scroll_speed">scrollbar scroll speed</label></th>
			<td>
				<input id="scroll_speed" type="text" name="msscroll_options[scroll_speed]" value="<?php echo stripslashes($settings['scroll_speed']); ?>" class="my-color-field" /><p class="description">Select scroll bar speed here. default value is 60. If you increase value, the scrolling speed will slow.you want will be scrolling speed faster</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="auto_hide_mode">scrollber visibility sitting </label></th>
			<td>
				<?php foreach( $auto_hide_mode as $activate ) : ?>
				<input type="radio" id="<?php echo $activate['value']; ?>" name="msscroll_options[auto_hide_mode]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['auto_hide_mode'], $activate['value'] ); ?> />
				<label for="<?php echo $activate['value']; ?>"><?php echo $activate['label']; ?></label><br />
				<?php endforeach; ?>
			</td>
		</tr>

	</table>

		<tr>
			<td align="center"><input type="submit" class="button-secondary" name="scrollbar_options[back_as_default]" value="Back as default" /></td>
			<td colspan="2"><input type="submit" class="button-primary" value="Save Settings" /></td>
		</tr>
	</form>

	</div>

	<?php
}

	
	function automaticpageload_validate_options( $input ) {
	global $msscroll_options, $auto_hide_mode;
	
	$settings = get_option( 'msscroll_options', $msscroll_options );
	
	// We strip all tags from the text field, to avoid Vulnerabilities like XSS
	
	$input['cursor_color'] = isset( $input['back_as_default'] ) ? '#02b2fd' : wp_filter_post_kses( $input['cursor_color'] );
	$input['cursor_width'] = isset( $input['back_as_default'] ) ? '10px' : wp_filter_post_kses( $input['cursor_width'] ); 
	$input['cursor_border_radius'] = isset( $input['back_as_default'] ) ? '5px' : wp_filter_post_kses( $input['cursor_border_radius'] );
	$input['cursor_border_width'] = isset( $input['back_as_default'] ) ? '0px' : wp_filter_post_kses( $input['cursor_border_width'] );
	$input['cursor_background_color'] = isset( $input['back_as_default'] ) ? '#1e1f23' : wp_filter_post_kses( $input['cursor_background_color'] );
	$input['cursor_border_color'] = isset( $input['back_as_default'] ) ? '#1e1f23' : wp_filter_post_kses( $input['cursor_border_color'] );
	$input['scroll_speed'] = isset( $input['back_to_default'] ) ? '60' : wp_filter_post_kses( $input['scroll_speed'] );
	$input['auto_hide_mode'] = isset( $input['back_to_default'] ) ? 'false' : wp_filter_post_kses( $input['auto_hide_mode'] );

	// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_only'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $auto_hide_mode ) )
		$input['layout_only'] = $prev;	
		
	
	
	return $input;
}

endif;		// Endif is_admin()




?>