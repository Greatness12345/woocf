<?php 
/**
 * @package  AlecadddPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseManager;

class AdminCallbacks extends BaseManager
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	public function adminCustomFees()
	{
		return require_once( "$this->plugin_path/templates/custom_fees.php" );
	}

	public function adminCustomPayment()
	{
		return require_once( "$this->plugin_path/templates/custom_payment.php" );
	}

    public function adminCustomShipping()
	{
		return require_once( "$this->plugin_path/templates/custom_shipping.php" );
	}
	public function adminSmsNotifier()
	{
		return require_once( "$this->plugin_path/templates/sms_notifier.php" );
	}

}