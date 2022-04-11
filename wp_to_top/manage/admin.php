<?php
if ( ! defined( 'ABSPATH' ) ) exit;


// When the save button is clicked
$Totop_save = @$_POST['Totop_save'];
$Totop_save = wp_kses($Totop_save, array());

if ( isset($Totop_save)){
	// Nonce Check
	if (isset($_POST['_wpnonce']) && $_POST['_wpnonce']){
		if (check_admin_referer('WPtotop_plugin','_wpnonce')){
      //POST variables
      // For security reasons, if you have just 2 options available, use the terinary operation like this to assign either of the values
     $WP_to_top_speed = ( @$_POST['WP_to_top_speed'] == 'fast' )? 'fast' : 'slow';
     //Register to the database
     update_option('WP_to_top_speed', $WP_to_top_speed);

     $WP_to_top_color = ( @$_POST['WP_to_top_color'] == 'blue' )? 'blue' : 'red';
       //Register to the database
       update_option('WP_to_top_color', $WP_to_top_color);
    }
	}
}
/***
* Receiving the data
***/
//Registered data
$WP_to_top_speed = get_option('WP_to_top_speed');
$WP_to_top_color = get_option('WP_to_top_color');

?>

<form method='post' id='wp_to_top_form' action=''>

  <?php // Nonce is an extra layer of security
  // This will ensure that the post values are coming from the web page of this options and not from any other part on the web
    wp_nonce_field(
      'WPtotop_plugin', // Name of Action
      '_wpnonce' // Name of nonce field
    );
   ?>

 <div class='wrap'><br />
	<h1>WP To Top <font size='2'>v1.0.0</font></h1>

 <table class='form-table'>
   <!-- The Speed Section of the Settings Options -->
	<tr valign='top'>
		<th width='50' scope='row'>To Top Scroll Speed</th>
		<td>
		<input type='radio' name='WP_to_top_speed' value='fast' <?php if($WP_to_top_speed == 'fast') echo('checked'); ?> /> Fast <br /> <br />
		<input type='radio' name='WP_to_top_speed' value='slow' <?php if($WP_to_top_speed == 'slow') echo('checked'); ?> /> Slow <br />
		</td>
	</tr>

  <!-- The Color sections of the settings page -->
  <tr valign='top'>
		<th width='50' scope='row'>To Top Scroll Speed</th>
		<td>
		<input type='radio' name='WP_to_top_color' value='red' <?php if($WP_to_top_color == 'red') echo('checked'); ?> /> Red <br /> <br />
		<input type='radio' name='WP_to_top_color' value='blue' <?php if($WP_to_top_color == 'blue') echo('checked'); ?> /> Blue <br />
		</td>
	</tr>

  <!-- Form Submission Section -->
  <tr>
  	<th width='50' scope='row'>Save this Settings</th>
  	<td>
  	<input type='submit' name='Totop_save' value='Save' /><br />
  	</td>
  </tr>
</table>
</form>
</div>
