<?php
/*
 *	Plugin Name: coffeeGreet
 *	Description: Greet your visitors with coffee.
 *	Version: 1.0
 *	Author:	bunniesandcreams.
 *	Author URI: http://adodcespresso.com
*/

add_action('admin_menu', 'cg_addPages');

function cg_loadStyles() {
	$plugindir = get_settings('home').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));
	echo "<link rel='stylesheet' href='$plugindir/styles.css' type='text/css' />";
}

function cg_addPages() {
	$mypage = add_options_page("Coffee Greet Widget", "Coffee Greet Widget", 1, "CoffeeGreet","cg_editOptions");
	add_action( "admin_print_scripts-$mypage", 'cg_loadStyles' );
}

function cg_editOptions() {
    echo "<h2>Edit Your Coffee Menu</h2>";
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $get=get_bloginfo('wpurl');



    //Read in existing option value from database
    $morning = get_option( 'cg_morning_coffee' );
    $afternoon = get_option( 'cg_afternoon_coffee' );
    $evening = get_option( 'cg_evening_coffee' );
    $message = get_option( 'cg_message' );
	$size = get_option( 'cg_size' );
	$shuffle = get_option( 'cg_shuffle' );
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
	$sizes = array('s','t','m','-','z');
	$size = (!in_array($size,$sizes)) ? 'm' : $size;
	if( isset($_POST[ 'my_salt' ]) && $_POST[ 'my_salt' ] == 'Y' ) {
		// Read their posted value
		$morning = $_POST[ 'cg_morning_coffee' ];
		$afternoon = $_POST[ 'cg_afternoon_coffee' ];
		$evening = $_POST[ 'cg_evening_coffee' ];
		$size = $_POST[ 'cg_size' ];
		$message = $_POST[ 'cg_message' ];
		$size = (!in_array($size,$sizes)) ? 'm' : $size;
		$shuffle = $_POST[ 'cg_shuffle' ];
		// Save the posted value in the database

		update_option( 'cg_morning_coffee', $morning );
		update_option( 'cg_afternoon_coffee', $afternoon );
		update_option( 'cg_evening_coffee', $evening );
		update_option( 'cg_message', $message );
		update_option( 'cg_size', $size );
		update_option( 'cg_shuffle', $shuffle );
        // Put an settings updated message on the screen

		_e('<div class="updated"><p><strong>Settings succesfully saved.</strong></p></div>', 'menu-test' );
	}
	// Now display the settings editing screen

    echo '<div class="wrap">';
    // header

    echo "<h2>" . __( 'Set Your Coffee Menu', 'menu-test' ) . "</h2><hr/>";

    // settings form:
?>
	<form id='cg_form' action='' method='post' name='form1'>
		<input type="hidden" name="my_salt" value="Y" />
		<fieldset>
			<label>Enter Tags for morning coffee:  </label>
			<input size='75' type='text' name='cg_morning_coffee' value='<?php echo $morning; ?>' />
		</fieldset>
		<fieldset>
			<label>Enter Tags for afternoon coffee:  </label>
			<input size='75' type='text' name='cg_afternoon_coffee' value='<?php echo $afternoon; ?>' />
		</fieldset>
		<fieldset>
			<label>Enter Tags for evening coffee:  </label>
			<input size='75' type='text' name='cg_evening_coffee' value='<?php echo $evening; ?>' />			
		</fieldset>
		<p>
			<br/>*Note: Separate your tags with comma. 
			<br/>*suggestions: machiatto,espresso,kopi-luak,frapuccino,praline-mocha,capuccino,decaf,Bugishu,Costa-Rican-coffee
		</p>
		<fieldset>
			<label>Enter the message to serve your coffee with:  </label>
			<input size='75' type='text' name='cg_message' value='<?php echo $message; ?>' />
		</fieldset>
		
		<br/>
		<h2>Set Options for Coffee Pictures</h2>
		<hr/>
			<fieldset>
				<label>Size: </label>
				<select name='cg_width' value='<?php echo $size; ?>'>
					<option value='s'>Small square 75x75</option>
					<option value='t'>Thumbnail, 100 on longest side</option>
					<option value='m' <?php if($size=='m' || $size=='') echo "selected='selected'"; ?>>Small, 240 on longest side</option>
					<option value='-'>Medium, 500 on longest side</option>
					<option value='z'>Medium, 640 on longest side</option>
				</select>
				<p>
					* More information regarding the valid sizes can be found at <a href='http://www.flickr.com/help/photos#18'>http://www.flickr.com/help/photos#18</a><br/>					
				</p>
			</fieldset>
			<fieldset>
				<label>Shuffle: </label>
				<input size='75' type='text' name='cg_shuffle' value='<?php echo $shuffle; ?>' />
				<p>
				<br/>* (Optional, defaults to 10)
				<br/>* How many images to fetch on flickr (a larger value gives more variety but loads a little slower)
				</p>
			</fieldset>
			<br/>
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
		</p>
	</form>
<?php
	echo "</div>";
}
function cg_coffeeGreetWidget($args)  {

		// echo "<pre>";
		// var_dump($args);
		// echo "</pre>";
		
	$cg_current_time = date(G);
	$cg_morning 	=	explode(",", get_option('cg_morning_coffee',""));
	$cg_afternoon 	= 	explode(",", get_option('cg_afternoon_coffee',""));
	$cg_evening 	=	explode(",", get_option('cg_evening_coffee',""));
	$cg_default 	=	explode(",", "coffee,kape,kaffe");
	$message		=	get_option('cg_message',"Want some coffee?");	
	$cg_size		=	get_option('cg_size',"m");	
	$cg_shuffle 	=	get_option('cg_shuffle',"10");
	
	//verify values
	$cg_sizes = array('s','t','m','-','z');
	$cg_size = (!in_array($cg_size,$cg_sizes)) ? 'm' : $cg_size;
	$cg_shuffle = (!ctype_digit ( $cg_shuffle )) ? '10' : $cg_shuffle;
	$message = ($message == '' ) ? 'Want some coffee?' : $message;

	$cg_index = rand(0,$cg_shuffle - 1);
	if($cg_current_time >= 6 && $cg_current_time <= 11 && $cg_morning!=''){
		$greeting = "Good Morning";
		$cg_url =	urlencode($cg_morning[rand(0,count($cg_morning)-1)]) ."&privacy_filter=1&safe_search=1&per_page=$cg_shuffle&sort=relevance&format=php_serial";
	}
	elseif($cg_current_time >= 12 && $cg_current_time <= 16 && $cg_afternoon!=''){
		$greeting = "Good Afternoon";
		$cg_url =	urlencode($cg_afternoon[rand(0,count($cg_afternoon)-1)])."&privacy_filter=1&safe_search=1&per_page=$cg_shuffle&sort=relevance&format=php_serial";
	}
	elseif($cg_current_time >= 17 && $cg_current_time <= 24 && $cg_evening!=''){
		$greeting = "Good Evening";
		$cg_url =	urlencode($cg_evening[rand(0,count($cg_evening)-1)])."&privacy_filter=1&safe_search=1&per_page=$cg_shuffle&sort=relevance&format=php_serial";
	}
	else{
		$greeting = "Hello :)";
		$cg_url =	$cg_default[rand(0,count($cg_default)-1)]."&privacy_filter=1&safe_search=1&per_page=$cg_shuffle&sort=relevance&format=php_serial";
	}
   
	$cg_url = "http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=f37d1b2fc679bf90abbded54e79631e9&tags=" . $cg_url;
	//$opts = array('http' => array('proxy' => 'tcp://127.0.0.1:9666', 'request_fulluri' => true));
	//$context = stream_context_create($opts);
	//$cg_result = file_get_contents($cg_url, false, $context);
	$cg_result = file_get_contents($cg_url);
	$cg_result = unserialize($cg_result);
	$cg_serve_me = '<img style="display: block;margin: 0 auto;" src="http://farm'
					. $cg_result['photos']['photo'][$cg_index]["farm"]
					. '.static.flickr.com/'
					. $cg_result['photos']['photo'][$cg_index]["server"]
					. '/' . $cg_result['photos']['photo'][$cg_index]["id"]
					. '_' . $cg_result['photos']['photo'][$cg_index]["secret"]
					. '_'. $cg_size.'.jpg" />';

		    extract($args); // gives us the defaulting settings of widgets
			$output = '<ul><li>'.$message.'</li><li>'.$cg_serve_me.'</li></ul>';
 echo $before_widget;
 echo $before_title . $greeting . $after_title;
 echo $output;
 echo $after_widget;
}


function cg_coffeeGreetAdmin()	{
  	$geturl=get_bloginfo('wpurl');
	echo '<a href="'.$geturl.'/wp-admin/options-general.php?page=CoffeeGreet">Go to Settings Page</a>';
}

function cg_startCoffeeGreet(){
  register_sidebar_widget(__('coffeeGreet'), 'cg_coffeeGreetWidget');
	//register_sidebar_widget(__('CoffeeGreet Widget'), 'cg_registerCoffeeGreet');
    //wp_register_sidebar_widget( 'coffeeGreet', 'Coffee Greetings', 'cg_coffeeGreetWidget'); 
    wp_register_widget_control('coffeeGreet','Coffee Greet','cg_coffeeGreetAdmin',200,200);
}

add_action("plugins_loaded", "cg_startCoffeeGreet");
?>