<?php

if(!function_exists('anyguide_plugin_get_version')) {
	function anyguide_plugin_get_version() {
		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$plugin_folder = get_plugins( '/' . plugin_basename( dirname( ANYGUIDE_PLUGIN_FILE ) ) );
			// 		print_r($plugin_folder);
			return $plugin_folder['anyguide.php']['Version'];
	}
}

if(!function_exists('anyguide_trim_deep')) {
	function anyguide_trim_deep($value) {
		if ( is_array($value) ) {
			$value = array_map('anyguide_trim_deep', $value);
		} elseif ( is_object($value) ) {
			$vars = get_object_vars( $value );
			foreach ($vars as $key=>$data) {
				$value->{$key} = anyguide_trim_deep( $data );
			}
		} else {
			$value = trim($value);
		}
		return $value;
	}
}


if(!function_exists('anyguide_links')) {
	function anyguide_links($links, $file) {
		$base = plugin_basename(ANYGUIDE_PLUGIN_FILE);
		if ($file == $base) {
			$links[] = '<a href="#" class="anyguide_support" title="Support"></a>';
			$links[] = '<a href="#" class="anyguide_twitt" title="Follow us on Twitter"></a>';
			$links[] = '<a href="#" class="anyguide_fbook" title="Like us on Facebook"></a>';
			$links[] = '<a href="#" class="anyguide_gplus" title="+1"></a>';
		}
		return $links;
	}
}

add_filter( 'plugin_row_meta','anyguide_links',10,2);

?>