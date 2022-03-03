<?php 
/**
 * @package  AlecadddPlugin
 */
namespace Inc;

use Inc\Api\SettingsApi;
use Inc\Base\BaseManager;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class Dashboard extends BaseManager
{
	public $settings;

	public $callbacks;

	public $callbacks_mngr;

	public $pages = array();

	public function register()
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->callbacks_mngr = new ManagerCallbacks();

		$this->setPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'Woocommerce Custom Features', 
				'menu_title' => 'WooCF', 
				'capability' => 'manage_options', 
				'menu_slug' => 'woocommerce-custom-features', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-money-alt', 
				'position' => 59
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'woocf_settings',
				'option_name' => 'woo_custom_features',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'woocf_admin_index',
				'title' => 'Settings Manager',
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page' => 'woocommerce_custom_features'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array();

		foreach ( $this->managers as $key => $value ) {
			$args[] = array(
				'id' => $key,
				'title' => $value,
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'woocommerce_custom_features',
				'section' => 'woocf_admin_index',
				'args' => array(
					'option_name' => 'woo_custom_features',
					'label_for' => $key,
					'class' => 'ui-toggle'
				)
			);
		}

		$this->settings->setFields( $args );
	}
}