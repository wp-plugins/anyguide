<?php 

function anyguide_network_uninstall($networkwide) {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				anyguide_uninstall();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	anyguide_uninstall();
}

function anyguide_uninstall(){
	global $wpdb;

	delete_option("anyguide_limit");
	$wpdb->query("DROP TABLE ".$wpdb->prefix."anyguide_short_code");
}

register_uninstall_hook( ANYGUIDE_PLUGIN_FILE, 'anyguide_network_uninstall' );
?>