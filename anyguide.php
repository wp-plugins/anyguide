<?php
/**
* @package   Anyguide
* @author    Anyguide <info@anyguide.com>
* @license   GPL-2.0+
* @link      http://anyguide.com
* @copyright 2015 Anyguide
*
* Plugin Name:       Anyguide 
* Plugin URI:        http://www.anyguide.com
* Description:       This plugin allows you to integrate the Anyguide booking solution into your Wordpress site.
* Version:           1.3
* Author:            anyguide.com
* Author URI:        http://anyguide.com/
* Text Domain:       anyguide
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

ob_start();
define('ANYGUIDE_PLUGIN_FILE',__FILE__);

require( dirname( __FILE__ ) . '/ag-functions.php' );
require( dirname( __FILE__ ) . '/shortcode_tynimce.php' );
require( dirname( __FILE__ ) . '/admin/install.php' );
require( dirname( __FILE__ ) . '/admin/menu.php' );
require( dirname( __FILE__ ) . '/shortcode-handler.php' );
require( dirname( __FILE__ ) . '/admin/uninstall.php' );
require( dirname( __FILE__ ) . '/direct_call.php' );

?>