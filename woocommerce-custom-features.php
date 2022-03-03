<?php
/**
 * @package  WoocommerceCustomFeatures
 */
/*
Plugin Name:  Woocommerce Custom Features
Plugin URI: http://woocommercecustomfeatures.smacomtech.com/
Description: This plugin provides custom features for your woocommerce website.
Version: 1.0.0
Author: Shedrack Uzouzobona
Author URI: http://profile.smacomtech.com
License: GPLv2 or later
Text Domain: woocommerce-custom-features
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

/// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}


/**
 * The code that runs during plugin activation
 */
 require_once "inc/Base/Activate.php ";
 
function activate_woocommerce_custom_features(){
	
			Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_woocommerce_custom_features' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_woocommerce_custom_features() {
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_custom_features' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::registerServices();
}