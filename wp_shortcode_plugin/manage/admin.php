<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/***
 * Admin page
***/
?>
<div class="wrap"><br/>
	<h1>WP Short Code Plugin <font size="2">v1.0.0</font></h1>
<?php
	 /***
	   * Save button is clicked
	 ***/
 	 $WP_Sample_shortcode_save = @$_POST['WP_Sample_shortcode_save'];
     $WP_Sample_shortcode_save = wp_kses($WP_Sample_shortcode_save, array());

		if ( isset( $WP_Sample_shortcode_save )){

		   //nonce check
	       if ( isset( $_POST['_wpnonce'] ) && $_POST['_wpnonce'] ) {
	            if ( check_admin_referer( 'WP_Sample_shortcode_save', '_wpnonce' ) ) {

                    //POST variables
                    $wp_shortcode_plugin_btntitle = @$_POST['wp_shortcode_plugin_btntitle'];
					$wp_shortcode_plugin_btntitle = wp_kses($wp_shortcode_plugin_btntitle, array());
                        //Register to the database
    				    update_option('wp_shortcode_plugin_btntitle', $wp_shortcode_plugin_btntitle);

                    $wp_shortcode_plugin_btn_url = @$_POST['wp_shortcode_plugin_btn_url'];
                    $wp_shortcode_plugin_btn_url = wp_kses($wp_shortcode_plugin_btn_url, array());
                        //Register to the database
                        update_option('wp_shortcode_plugin_btn_url', $wp_shortcode_plugin_btn_url);

					$wp_short_code_sample_backcolor = @$_POST['wp_short_code_sample_backcolor'];
                    $wp_short_code_sample_backcolor = wp_kses($wp_short_code_sample_backcolor, array());
                        //Register to the database
                        update_option('wp_short_code_sample_backcolor', $wp_short_code_sample_backcolor);

					$wp_short_code_sample_namecolor = @$_POST['wp_short_code_sample_namecolor'];
                    $wp_short_code_sample_namecolor = wp_kses($wp_short_code_sample_namecolor, array());
                        //Register to the database
                        update_option('wp_short_code_sample_namecolor', $wp_short_code_sample_namecolor);
        }
           }
                }
    //Registered data
	$wp_shortcode_plugin_btntitle = get_option('wp_shortcode_plugin_btntitle');
    $wp_shortcode_plugin_shortcode = get_option('wp_shortcode_plugin_shortcode');
    $wp_shortcode_plugin_btn_url = get_option('wp_shortcode_plugin_btn_url');
	$wp_short_code_sample_backcolor = get_option('wp_short_code_sample_backcolor');
	$wp_short_code_sample_namecolor = get_option('wp_short_code_sample_namecolor');
 ?>
 <form method="post" id="WP_Sample_shortcode_save" action="">
     <?php wp_nonce_field( 'WP_Sample_shortcode_save', '_wpnonce' ); ?>

     <table class="form-table">

         <tr valign="top">
             <td>
                 <span>Button Name:</span>
                 <br>
                 <input name="wp_shortcode_plugin_btntitle" type="text" value="<?php echo esc_attr($wp_shortcode_plugin_btntitle); ?>" size="30"/>
             </td>

             <td>
                 <span>Button Preview:</span>
                 <div style="font-size:15px !important;
                             border: solid #a4a4a4 1px;
                             padding:10px;
                             width:150px;
                             text-align:center;
                             color:<?php echo $wp_short_code_sample_namecolor; ?>;
                             background-color:<?php echo $wp_short_code_sample_backcolor; ?>;">
                            <?php echo $wp_shortcode_plugin_btntitle; ?>
                 </div>
             </td>
         </tr>

		 <tr valign="top">
             <td>
                 <span>Button Background Color:</span>
				 <br>
				 <input type="text" name="wp_short_code_sample_backcolor" value="<?php echo esc_attr($wp_short_code_sample_backcolor); ?>" class="Short_Code_Sample_ColorPicker" >
             </td>

             <td>
                 <span>Button Name Color:</span>
                 <br>
                 <input type="text" name="wp_short_code_sample_namecolor" value="<?php echo esc_attr($wp_short_code_sample_namecolor); ?>" class="Short_Code_Sample_ColorPicker" >
             </td>
         </tr>

         <tr valign="top">
             <td>
                 <span>Copy short code to place the button:</span>
                 <br>
                 <input name="wp_shortcode_plugin_shortcode" type="text" value="<?php echo esc_attr($wp_shortcode_plugin_shortcode); ?>" size="30">
             </td>

             <td>
                 <span>Insert link URL:</span>
                 <br>
                 <input name="wp_shortcode_plugin_btn_url" type="text" placeholder="ex. https://www.yahoo.com"value="<?php echo esc_url($wp_shortcode_plugin_btn_url); ?>" size="50">
             </td>
         </tr>

         <tr>
             <th width="50" scope="row">Save this setting</th>
             <td>
             <input type="submit" name="WP_Sample_shortcode_save" value="Save" /><br />
              </td>
         </tr>
     </table>
 </form>
</div>
