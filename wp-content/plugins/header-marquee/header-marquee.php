<?php
/*
Plugin name: Header-Marquee
Description: This plugin will show a moving text (Marquee). The displayed text can be changed from Settings/Header-Marquee menu.
Version: 1.1
License: GPL
Text Domain: header-marquee
Domain Path: /languages/
*/

function hm_header_marquee()
{
	
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false && !strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== false) {
    // User agent is Google Chrome
	$final_string = '<marquee behavior=scroll direction='.get_option('header_marquee_data_1');
	$final_string .= ' scrollamount='.get_option('header_marquee_data_2').' ';
	$final_string .= ' scrolldelay='.get_option('header_marquee_data_6').' ';
	$final_string .= '>'; 
	echo '<div id="mar">'.$final_string.get_option('header_marquee_data').'</marquee></div>';
 }
 else {
	//Not chrome 
	$final_string = '';
	echo '<div style="overflow-x: hidden;"><div id="mar">'.$final_string.get_option('header_marquee_data').'</div></div>';
 }
}

function hm_marquee_css()
{
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false && !strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== false) {
	echo '
	<style type='."text/css".'>
	#mar
	{
		width: '.get_option('header_marquee_data_8').'%;
		height: '.get_option('header_marquee_data_7').'px;
		background-color: '.get_option('header_marquee_data_5').';
		font-size: '.get_option('header_marquee_data_11').'%;
		margin-left: '.get_option('header_marquee_data_9').'px;
		margin-right: '.get_option('header_marquee_data_10').'px;
		margin-top: '.get_option('header_marquee_data_12').'px;
		margin-bottom: '.get_option('header_marquee_data_13').'px;
	}
	</style>';
}
else
{ 
	echo '
	<style type='."text/css".'>
	@keyframes marquee {
  0% {
    left: 100%;
  }
  100% {
    left: -'.get_option('header_marquee_data_15').'%; /* need to be negative */
  }
}
	#mar
    {
        display: block;
        position: relative;
        height: '.get_option('header_marquee_data_7').'px;
		width: '.get_option('header_marquee_data_8').'%;
		background: '.get_option('header_marquee_data_5').';
		font-size: '.get_option('header_marquee_data_11').'%;
		margin-left: '.get_option('header_marquee_data_9').'px;
		margin-right: '.get_option('header_marquee_data_10').'px;
		margin-top: '.get_option('header_marquee_data_12').'px;
		margin-bottom: '.get_option('header_marquee_data_13').'px;
        animation: marquee '.get_option('header_marquee_data_14').'s linear infinite; 
}	
	</style>';
}
}
add_action('wp_head','hm_marquee_css');

if (get_option('header_marquee_data_3')!="none") add_action('wp_'.get_option('header_marquee_data_3').'','hm_header_marquee');


function hm_header_init()
{
	add_option("header_marquee_data", 'Hello World', '', 'yes');
	add_option("header_marquee_data_1", 'left', '', 'yes');
	add_option("header_marquee_data_2", 6, '', 'yes');
	add_option("header_marquee_data_3", 'none', '', 'yes');
	add_option("header_marquee_data_4", '#ffffff', '', 'yes');
	add_option("header_marquee_data_5", '#000000', '', 'yes');
	add_option("header_marquee_data_6", 85, '', 'yes');
	add_option("header_marquee_data_7", 50, '', 'yes');
	add_option("header_marquee_data_8", 100, '', 'yes');
	add_option("header_marquee_data_9", 0, '', 'yes');
	add_option("header_marquee_data_10", 0, '', 'yes');
	add_option("header_marquee_data_11", 100, '', 'yes');
	add_option("header_marquee_data_12", 0, '', 'yes');
	add_option("header_marquee_data_13", 0, '', 'yes');
	add_option("header_marquee_data_14", 20, '', 'yes');
	add_option("header_marquee_data_15", 50, '', 'yes');
}

function hm_header_dest()
{
	delete_option("header_marquee_data");
	delete_option("header_marquee_data_1");
	delete_option("header_marquee_data_2");
	delete_option("header_marquee_data_3");
	delete_option("header_marquee_data_4");
	delete_option("header_marquee_data_5");
	delete_option("header_marquee_data_6");
	delete_option("header_marquee_data_7");
	delete_option("header_marquee_data_8");
	delete_option("header_marquee_data_9");
	delete_option("header_marquee_data_10");
	delete_option("header_marquee_data_11");
	delete_option("header_marquee_data_12");
	delete_option("header_marquee_data_13");
	delete_option("header_marquee_data_14");
	delete_option("header_marquee_data_15");
}

register_activation_hook(__FILE__, 'hm_header_init');
register_deactivation_hook(__FILE__, 'hm_header_dest');

if(is_admin())
{
	add_action('admin_menu', 'hm_header_marquee_admin_menu');
	function hm_header_marquee_admin_menu()
	{
		add_options_page('Header-Marquee', 'Header-Marquee', 'administrator',
		'header-marquee', 'hm_header_marquee_html_page');
	}
	add_action( 'admin_init', 'hm_register_header_marquee' );
}

function hm_register_header_marquee()
{
	register_setting( 'header_marquee-group', 'header_marquee_data' ); // Enter Text
	register_setting( 'header_marquee-group', 'header_marquee_data_1' ); //Direction of Scrolling
	register_setting( 'header_marquee-group', 'header_marquee_data_2' ); //Scrolling Speed
	register_setting( 'header_marquee-group', 'header_marquee_data_3' ); //Location of Text
	register_setting( 'header_marquee-group', 'header_marquee_data_4' ); //Text Color
	register_setting( 'header_marquee-group', 'header_marquee_data_5' ); //Background Color
	register_setting( 'header_marquee-group', 'header_marquee_data_6' ); //Scrolling Delay
	register_setting( 'header_marquee-group', 'header_marquee_data_7' ); //Height
	register_setting( 'header_marquee-group', 'header_marquee_data_8' ); //Width
	register_setting( 'header_marquee-group', 'header_marquee_data_9' ); //Margin From Left
	register_setting( 'header_marquee-group', 'header_marquee_data_10' ); //Margin From Right
	register_setting( 'header_marquee-group', 'header_marquee_data_11' ); //Font Size
	register_setting( 'header_marquee-group', 'header_marquee_data_12' ); //Margin From Top
	register_setting( 'header_marquee-group', 'header_marquee_data_13' ); //Margin From Bottom
	register_setting( 'header_marquee-group', 'header_marquee_data_14' ); //Text time speed for Firefox
	register_setting( 'header_marquee-group', 'header_marquee_data_15' ); //Text space for Firefox
	wp_register_style( 'headermarqueesheet', plugins_url( 'header_marquee.css', __FILE__ ) );
}

add_action( 'admin_enqueue_scripts', 'hm_mw_enqueue_color_picker' );
function hm_mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'headermarqueesheet' );
    wp_enqueue_script( 'my-script-handle', plugins_url('header-marquee-js.js', __FILE__ ), array( 'wp-color-picker', 'jquery'), false, true );
	 wp_enqueue_script( 'my-script-handle_1', plugins_url('header-marquee-js1.js', __FILE__ ), array('jquery'), time(), true );
	 
}

function hm_validate_text($data,$length,$default=0)
{
	$copy = intval($data);
	$validate = true;
	if(preg_match( "/[^0-9.-]/", $data))
	{
		$copy = $default;
		$validate = false;
	}
		
	if(strlen($copy) > $length)
	{
		$copy = substr($copy,0,$length);
		$validate = false;
	}
	if($copy < 0)
	{
		$copy = $default;
		$validate = false;	
	}
	return array($copy,$validate);
}

function hm_header_marquee_html_page() {
?>
<div class="warp">
<h2><?php _e('Header Marquee Options','header-marquee'); ?></h2>

<form method="post" action="options.php">
	<?php settings_fields( 'header_marquee-group' ); ?>
	<?php do_settings_sections( 'header_marquee-group' ); ?>
	<table class="form-table">
		<tr >
			<th scope="row"><?php _e('Enter Text','header-marquee'); ?></th>
			<td >
				<?php
				$settings = array('editor_height' => 50);
				$content = wp_kses_post(get_option('header_marquee_data'));
				$editor_id = 'header_marquee_data';

				wp_editor( $content, $editor_id, $settings );
				?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Direction of Scrolling','header-marquee'); ?></th>
			<td>
			<label><input type="radio" name = "header_marquee_data_1" id = "header_marquee_data_1" value="left" <?php
			checked('left', get_option( 'header_marquee_data_1' ));?>/> <?php _e('from Left','header-marquee'); ?> </label><br>
			<label><input type="radio" name = "header_marquee_data_1" id = "header_marquee_data_1" value="right" <?php
		checked('right', get_option( 'header_marquee_data_1' ));?>/> <?php _e('from Right','header-marquee'); ?> </label><br>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Scrolling Speed','header-marquee'); ?></th>
			<td id="option_1">
				<input name="header_marquee_data_2" type="text" size="1" id="header_marquee_data_2" maxlength="2"
				value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_2'),2,6);
				echo $check[0];

				?>" /> <input type = "button" value="X" class="D-B" /> <br>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>
        <tr>    
            <th scope="row"><?php _e('Scrolling speed for other then Chrome browsers','header-marquee'); ?></th>
			<td id="option_1b">
				<input name="header_marquee_data_14" type="text" size="1" id="header_marquee_data_14" maxlength="2"
				value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_14'),2,20);
				echo $check[0];

				?>" /> <input type = "button" value="X" class="D-B" /> <br>
				<p class="description" id="delay-description"> <?php _e('Greater value means slower scrolling','header-marquee'); ?></p> <p class="description" id="delay-description-3"></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>

			<th scope="row"><?php _e('Text space for other then Chrome browsers','header-marquee'); ?></th>
			<td id="option_1b">
				<input name="header_marquee_data_15" type="text" size="1" id="header_marquee_data_15" maxlength="3"
				value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_15'),3,50);
				echo $check[0];

				?>" /> <input type = "button" value="X" class="D-B" /> <br>
				<p class="description" id="space-description"> <?php _e('Greater value means more space for your message','header-marquee'); ?></p> <p class="description" id="space-description-3"></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		
			
		</tr>
		<tr>
			<th scope="row"><?php _e('Scrolling Delay','header-marquee'); ?></th>
			<td id="option_2">
			<input type="text" id="header_marquee_data_6" name="header_marquee_data_6" size="7" maxlength="9" value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_6'),9,85);
				echo $check[0];
				?>" /> <input type = "button" value="X" class="D-B" />
				 <br><p class="description" id="delay-description"> <?php _e('Value is set in miliseconds  (1/1000th of the second)','header-marquee'); ?></p> <p class="description" id="delay-description-2"> <?php _e('(if you don\'t want to use this parameter, then set this to 0)','header-marquee'); ?></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Location of Text','header-marquee'); ?></th>
			<td>
				<label>
					<label><input type="radio" name = "header_marquee_data_3" id = "header_marquee_data_3" value="none" <?php
					checked('none', get_option( 'header_marquee_data_3' ));?>/> <?php _e('None','header-marquee'); ?> </label><br>
				<input type="radio" name = "header_marquee_data_3" id = "header_marquee_data_3" value="head" <?php
						checked('head', get_option( 'header_marquee_data_3' ));?>/> <?php _e('Header','header-marquee'); ?> </label><br>
				<label><input type="radio" name = "header_marquee_data_3" id = "header_marquee_data_3" value="footer" <?php
					checked('footer', get_option( 'header_marquee_data_3' ));?>/> <?php _e('Footer','header-marquee'); ?> </label><br>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Text Color','header-marquee'); ?> </th>
			<td>
			<input type="text" id="header_marquee_data_4" name="header_marquee_data_4" value="<?php echo esc_attr(get_option('header_marquee_data_4')); ?>" class="my-color-field" />
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Background Color','header-marquee'); ?></th>
			<td>
			<input type="text"  id="header_marquee_data_5" name="header_marquee_data_5" value="<?php echo esc_attr(get_option('header_marquee_data_5')); ?>" class="my-color-field" />
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Height','header-marquee'); ?></th>
			<td id="option_3">
				<input type = "text"  id="header_marquee_data_7" name="header_marquee_data_7" size="1" maxlength="3" value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_7'),3,50);
				update_option('header_marquee_data_7', $check[0]);
				echo get_option('header_marquee_data_7');
				?>" /> <input type = "button" value="X" class="D-B" /> <br><p class="description" id="height-description"> <?php _e('in pixels','header-marquee'); ?></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Width','header-marquee'); ?></th>
			<td id="option_4">
			<input type = "text"  id="header_marquee_data_8" name="header_marquee_data_8" size="1" maxlength="3" value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_8'),3,100);
				update_option('header_marquee_data_8', $check[0]);
				echo get_option('header_marquee_data_8');
				?>" /> <input type = "button" value="X" class="D-B" />  <br><p class="description" id="width-description"> <?php _e('in %','header-marquee'); ?></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Margin from Left','header-marquee'); ?></th>
			<td id="option_5">
			<input type = "text"  id="header_marquee_data_9" name="header_marquee_data_9" size="1" maxlength="4" value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_9'),4,0);
				update_option('header_marquee_data_9', $check[0]);
				echo get_option('header_marquee_data_9');
				?>" /> <input type = "button" value="X" class="D-B" /> <br><p class="description" id="m-l-description"> <?php _e('in pixels','header-marquee'); ?></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Margin from Right','header-marquee'); ?></th>
			<td id="option_6">
			<input type = "text"  id="header_marquee_data_10" name="header_marquee_data_10" size="1" maxlength="4" value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_10'),4,0);
				update_option('header_marquee_data_10', $check[0]);
				echo get_option('header_marquee_data_10');
				?>" /> <input type = "button" value="X" class="D-B" /> <br><p class="description" id="m-r-description"> <?php _e('in pixels','header-marquee'); ?></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Margin from Top','header-marquee'); ?></th>
			<td id="option_8">
			<input type = "text"  id="header_marquee_data_12" name="header_marquee_data_12" size="1" maxlength="4" value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_12'),4,0);
				update_option('header_marquee_data_12', $check[0]);
				echo get_option('header_marquee_data_12');
				?>" /> <input type = "button" value="X" class="D-B" /> <br><p class="description" id="m-r-description"> <?php _e('in pixels','header-marquee'); ?></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Margin from Bottom','header-marquee'); ?></th>
			<td id="option_9">
			<input type = "text"  id="header_marquee_data_13" name="header_marquee_data_13" size="1" maxlength="4" value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_13'),4,0);
				update_option('header_marquee_data_13', $check[0]);
				echo get_option('header_marquee_data_13');
				?>" /> <input type = "button" value="X" class="D-B" /> <br><p class="description" id="m-r-description"> <?php _e('in pixels','header-marquee'); ?></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Font Size','header-marquee'); ?></th>
			<td id="option_7">
			<input type = "text" id="header_marquee_data_11" name="header_marquee_data_11" size="1" maxlength="3" value="<?php
				$check = hm_validate_text(get_option('header_marquee_data_11'),3,100);
				update_option('header_marquee_data_11', $check[0]);
				echo get_option('header_marquee_data_11');
				?>" /> <input type = "button" value="X" class="D-B" /> <br><p class="description" id="fs-description"> <?php _e('in %','header-marquee'); ?></p>
				<?php
				if(isset($check[1]) && (!$check[1]))
				{
					echo '<p style='."color:red;".'>'; 
					_e('This field must be a number, greater or equal to 0. Set to default.','header-marquee');
					echo '</p>';
					unset($check[1]);
				}
				?>
			</td>
		</tr>
	</table>
	
	
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="header_marquee_data" />
	<input type="hidden" name="page_options" value="header_marquee_data_1" />
	<input type="hidden" name="page_options" value="header_marquee_data_2" />
	<input type="hidden" name="page_options" value="header_marquee_data_3" />
	<input type="hidden" name="page_options" value="header_marquee_data_4" />
	<input type="hidden" name="page_options" value="header_marquee_data_5" />
	<input type="hidden" name="page_options" value="header_marquee_data_6" />
	<input type="hidden" name="page_options" value="header_marquee_data_7" />
	<input type="hidden" name="page_options" value="header_marquee_data_8" />
	<input type="hidden" name="page_options" value="header_marquee_data_9" />
	<input type="hidden" name="page_options" value="header_marquee_data_10" />
	<input type="hidden" name="page_options" value="header_marquee_data_11" />
	<input type="hidden" name="page_options" value="header_marquee_data_12" />
	<input type="hidden" name="page_options" value="header_marquee_data_13" />
	<input type="hidden" name="page_options" value="header_marquee_data_14" />
	

<?php submit_button(); ?>
</form>
</div>
<?php
}

	add_filter( 'mce_buttons_2', 'hm_acme_remove_firm_kitchen_sink');
	function hm_acme_remove_firm_kitchen_sink( $buttons ) {
	
	$unneded_button = array(
					  'hr',
					  'forecolor', //this is set throught different setting
					  'pastetext',
					  'outdent',
					  'indent',
					  'wp_help'
					  );
	
	foreach ( $buttons as $button_key => $button_value ) {
    
    		if( in_array( $button_value, $unneded_button ) ) {
      			unset( $buttons[ $button_key ] );
    		}
    
	}
	array_unshift($buttons, 'fontselect');
	return $buttons;
}
	add_filter( 'mce_buttons', 'hm_acme_remove_firm_basic');
	function hm_acme_remove_firm_basic( $buttons ) {
	
	$unneded_button = array(
					  'bullist',
					  'numlist',
					  'alignleft',
					  'aligncenter',
					  'alignright',
					  /*'link',
					  'unlink',*/
					  'more'
					  );
	
	foreach ( $buttons as $button_key => $button_value ) {
    
    		if( in_array( $button_value, $unneded_button ) ) {
      			unset( $buttons[ $button_key ] );
    		}
    
	}
	return $buttons;
}


function hm_wan_load_textdomain() {
	load_plugin_textdomain( 'header-marquee', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
add_action('plugins_loaded', 'hm_wan_load_textdomain');

?>