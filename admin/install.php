<?php

function anyguide_network_install($networkwide) {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs"); // Get all blog ids
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				anyguide_install();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	anyguide_install();
}

function anyguide_install(){
	global $wpdb;
	add_option('anyguide_limit',20);
	$queryInsertHtml = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."anyguide_short_code (
	  `id` int NOT NULL AUTO_INCREMENT,
		  `short_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `slug` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
		  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `status` int NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
	$wpdb->query($queryInsertHtml);
}

register_activation_hook( ANYGUIDE_PLUGIN_FILE ,'anyguide_network_install');