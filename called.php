<?php
/**
 * @package Called
 * @version 1.0
 */
/*
Plugin Name: Called.in Click To Call Plugin 
Plugin URI: http://ronakdave.wordpress.com/
Description: Called.in plugin for click to call functionality.
Author: Ronak Dave
Version: 1.0
Author URI: http://ronakdave.wordpress.com/
License: GPLv2
*/
$siteurl = get_option('siteurl');
define('CLD_FOLDER', dirname(plugin_basename(__FILE__)));
define('CLD_FILE_PATH', dirname(__FILE__));
define('CLD_DIR_NAME', basename(CLD_FILE_PATH));
add_action('admin_menu', 'called_in_plugin_menu');
function called_in_plugin_menu() {
	add_options_page('Called Plugin Setup', 'Called Settings ', 'manage_options', 'called', 'called_in_plugin_options');
}
function called_in_plugin_options() {
	include('back-end.php');
}
function called_in_view(){
?>
<form id="ctcform" method="post" action="" >
<input type="text" name="to-number" id="to-number" >
<input type="submit" id="clicktocall" name="submit" value="Call" >
</form>
<div id="show-this" style="display:none;" >... Your call is in progress please wait for a while</div>
<div id="show" style="display: none">Get the value back here</div>
<?php
include('clicked.php');	
}
function called_in_script(){
	$api_url = 'http://called.in/api/clicktocall/';
	$api_key = get_option('called_api_key');
	$caller_phone_number = get_option('called_callee_key');
	$caller_country_code = get_option('called_caller_key'); // North America
	//$callee_phone_number = $_POST['to-number'];//get_option("called_api_key");
	$callee_country_code = get_option('called_caller_isd_key');
	$max_duration = '3';
	$urltopass = "$api_url?api_key=$api_key&caller_phone_number=$caller_phone_number&caller_country_code=$caller_country_code&callee_country_code=$callee_country_code&max_duration=$max_duration";
?>
<script type="text/javascript">
function get_XmlHttp() {
		  // create the variable that will contain the instance of the XMLHttpRequest object (initially with null value)
		  var xmlHttp = null;
		
		  if(window.XMLHttpRequest) {		// for Forefox, IE7+, Opera, Safari, ...
			xmlHttp = new XMLHttpRequest();
		  }
		  else if(window.ActiveXObject) {	// for Internet Explorer 5 or 6
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		  }
		
		  return xmlHttp;
		}
		// sends data to a php file, via POST, and displays the received answer
		function ajaxrequest(php_file, tagID, the_url) {
		  var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
		  // create pairs index=value with data that must be sent to server
		  var  the_data = 'the_url='+the_url;
		  request.open("POST", php_file, true);			// set the request
		  //adds  a header to tell the PHP script to recognize the data as is sent via POST
		  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		  request.send(the_data);		// calls the send() method with datas as parameter
		  // Check request status
		  // If the response is received completely, will be transferred to the HTML tag with tagID
		  request.onreadystatechange = function() {
			if (request.readyState == 4) {
			  document.getElementById(tagID).innerHTML = request.responseText;
			}
		  }
		}
jQuery(document).ready(function() {
    jQuery('#clicktocall').click(function(){
		var num = jQuery('#to-number').val();
		if(num == ""){
			alert('Please enter a number to call!');
			return false;
		}
		if(jQuery.isNumeric( num )){
			jQuery('#show-this').show('slow');
			var tagID = "show";
			var the_url = "<?php echo $urltopass; ?>&callee_phone_number="+num;
			ajaxrequest("<?php echo plugins_url( 'clicked.php' , __FILE__ ); ?>", tagID, the_url)
			return false;
		}else{
			alert('Please enter a valid number!');
			return false;
		}
		return false;
	});
});
</script>
<?php
}
add_shortcode('called', 'called_in_view');
add_action('wp_footer', 'called_in_script');

class Called_in_Widget extends WP_Widget {
	/** constructor */
	function __construct() {
		parent::WP_Widget( /* Base ID */'Called_Widget', /* Name */'Called_Widget', array( 'description' => 'Called Widget' ) );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; 
			// Ronak your html coding will go here..
			if (!isset($_POST['submit'])) {
			?>
		<form id="ctcform" method="post" action="" >
		<input type="text" name="to-number" id="to-number" >
		<input type="submit" id="clicktocall" name="submit" value="Call" >
		</form>
		<div id="show-this" style="display:none;" >... Your call is in progress please wait for a while</div>
		<div id="show" style="display: none">Get the value back here</div>
		</form>
		<?php
		}
		else{
		echo "we have received the data";
		}
		 echo $after_widget;
	}
	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
		}
		else {
			$title = __( 'Enter New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php 
	}

} // class Called_Widget

function called_in_widget() {
	register_widget( 'Called_in_Widget' );
}
add_action( 'widgets_init', 'called_in_widget' );
?>