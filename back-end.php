<?php 
if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	    // variables for the field and option names 
    $opt_api = 'called_api_key';
	$opt_caller = 'called_caller_key';
	$opt_callee = 'called_callee_key';
	$opt_caller_isd = 'called_caller_isd_key';
	$opt_callee_isd = 'called_callee_isd_key';
    $hidden_field_name = 'mt_submit_hidden';
    $data_field_api = 'called_api_key';
	$data_field_caller = 'called_caller_key';
	$data_field_callee = 'called_callee_key';
	$data_field_caller_isd = 'called_caller_isd_key';
	$data_field_callee_isd = 'called_callee_isd_key';
    // Read in existing option value from database
    $opt_val1 = get_option( $opt_api );
	$opt_val2 = get_option( $opt_caller );
	$opt_val3 = get_option( $opt_callee );
	$opt_val4 = get_option( $opt_caller_isd );
	$opt_val5 = get_option( $opt_callee_isd );
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val1 = $_POST[ $data_field_api ];
		$opt_val2 = $_POST[ $data_field_caller ];
		$opt_val3 = $_POST[ $data_field_callee ];
		$opt_val4 = $_POST[ $data_field_caller_isd ];
		$opt_val5 = $_POST[ $data_field_callee_isd ];
        // Save the posted value in the database
        update_option( $opt_api, $opt_val1 );
		update_option( $opt_caller, $opt_val2 );
		update_option( $opt_callee, $opt_val3 );
		update_option( $opt_caller_isd, $opt_val4 );
		update_option( $opt_callee_isd, $opt_val5 );
        // Put an settings updated message on the screen
?>
<div class="updated"><p><strong><?php _e('settings saved.', 'called-plg' ); ?></strong></p></div>
<?php
    }
    // Now display the settings editing screen
    echo '<div class="wrap">';
    // header
    echo "<h2>" . __( 'Called Settings', 'called-plg' ) . "</h2>";
    // settings form
    ?>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<p><?php _e("Api Key:", 'called-plg' ); ?> 
<input type="text" name="<?php echo $data_field_api; ?>" value="<?php echo $opt_val1; ?>" size="20">
</p><hr />
<p><?php _e("Caller Country Code:", 'called-plg' ); ?> 
<input type="text" name="<?php echo $data_field_caller; ?>" value="<?php echo $opt_val2; ?>" size="20">
</p><hr />
<p><?php _e("Caller Phone Number:", 'called-plg' ); ?> 
<input type="text" name="<?php echo $data_field_callee; ?>" value="<?php echo $opt_val3; ?>" size="20">
</p><hr />
<p><?php _e("Callee Country Code:", 'called-plg' ); ?> 
<input type="text" name="<?php echo $data_field_caller_isd; ?>" value="<?php echo $opt_val4; ?>" size="20">
</p><hr />
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>
</form>
</div>
<div>
	<h3>To use this plugin you will have to get api from called.in, <a target="_blank" href="http://called.in/register/">click here</a> to get your api</h3>
</div>