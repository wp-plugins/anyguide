<?php

add_action('admin_menu', 'anyguide_menu');


function anyguide_menu(){
	add_menu_page('anyguide-snippet', 'Anyguide', 'manage_options', 'anyguide-manage','anyguide_snippets',plugins_url('assets/images/button16.png', dirname(__FILE__)));

	add_submenu_page('anyguide-manage', 'Anyguide Snippets', 'Snippets', 'manage_options', 'anyguide-manage',   'anyguide_snippets');
	add_submenu_page('anyguide-manage', 'Anyguide Snippets', 'Settings', 'manage_options', 'anyguide-settings', 'anyguide_settings');	
	add_submenu_page('anyguide-manage', 'Anyguide Snippets', 'Help',     'manage_options', 'anyguide-help',     'anyguide_help');
	add_submenu_page('anyguide-manage', 'Anyguide Snippets', 'About',    'manage_options', 'anyguide-about' ,   'anyguide_about');	
}

function anyguide_snippets(){
	$formflag = 0; // class="current" on item

	// Add Snippet
	if(isset($_GET['action']) && $_GET['action']=='snippet-add' ) {
		require( dirname( __FILE__ ) . '/snippet-add.php' );
		require( dirname( __FILE__ ) . '/footer.php' );
		$formflag=1;
	}

	// Edit Snippet
	if(isset($_GET['action']) && $_GET['action']=='snippet-edit' ) {
		include(dirname( __FILE__ ) . '/snippet-edit.php');
		require( dirname( __FILE__ ) . '/footer.php' );
		$formflag=1;
	}

	// Delete Snippet
	if(isset($_GET['action']) && $_GET['action']=='snippet-delete' ) {
		include(dirname( __FILE__ ) . '/snippet-delete.php');
		$formflag=1;
	}

	if($formflag == 0){
		require( dirname( __FILE__ ) . '/snippets.php' );
		require( dirname( __FILE__ ) . '/footer.php' );
	}
}

function anyguide_settings() {
	require( dirname( __FILE__ ) . '/settings.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}

function anyguide_about() {
	require( dirname( __FILE__ ) . '/about.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}

function anyguide_help() {
	require( dirname( __FILE__ ) . '/help.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}

function anyguide_admin_queue() {
	$array = array("anyguide-manage","anyguide-settings", "anyguide-help", "anyguide-about");

	if(0 < count(array_intersect(array_map('strtolower', explode(' ', $_GET['page'])), $array))) {
		wp_enqueue_script('jquery');

		wp_register_script('anyguide_notice_script', plugins_url('assets/js/notice.js', dirname(__FILE__)));
		wp_register_style('bootstrap', plugins_url('assets/css/bootstrap.css', dirname(__FILE__)));
		wp_register_style('anyguide_style', plugins_url('assets/css/anyguide_styles.css', dirname(__FILE__)));
		wp_register_style('dashboard',      plugins_url('assets/css/dashboard.css', dirname(__FILE__) ));
		wp_register_style('font-awesome', plugins_url('assets/css/font-awesome.css', dirname(__FILE__)), array(), '4.3.0' );
		wp_register_style('titillium', 'http://fonts.googleapis.com/css?family=Titillium+Web:400,600,700');

		wp_enqueue_style('titillium');
		wp_enqueue_style('dashboard');
		wp_enqueue_style('anyguide_style');
		wp_enqueue_style('bootstrap');
		wp_enqueue_style('font-awesome');
		wp_enqueue_script('anyguide_notice_script');
	}

	wp_register_style('global',      plugins_url('assets/css/global.css', dirname(__FILE__) ));
	wp_enqueue_style('global');
}

function anyguide_integration() {
	wp_enqueue_script('integration', 'https://www.anyguide.com/assets/integration.js');
	wp_enqueue_script('integration');
	
}

add_action('admin_enqueue_scripts', 'anyguide_admin_queue');
add_action('wp_enqueue_scripts', 'anyguide_integration');

?>

