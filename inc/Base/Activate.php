<?php
/**
 * @package   WoocommerceCustomFeatures
 */
namespace Inc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();
	
	    $default = array();

		if ( ! get_option( 'woo_custom_features' ) ) {
			update_option( 'woo_custom_features', $default );
		}
	}
	
	
}