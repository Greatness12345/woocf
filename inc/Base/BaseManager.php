<?php 
/**
 * @package  AlecadddPlugin
 */
namespace Inc\Base;

class BaseManager
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/woocommerce-custom-features.php';

		$this->managers = array(
			'custom_fees_manager' => 'Activate Custom Fees',
			'custom_payment_manager' => 'Activate Custom Payment',
			'custom_shipping_manager' => 'Activate Custom Shipping',
			'sms_notifier' => 'Activate Sms Notifier'
		);
	}

	public function activated( string $key )
	{
		$option = get_option( 'woo_custom_features' );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}