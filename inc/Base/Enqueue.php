<?php 
/**
 * @package  AlecadddPlugin
 */
namespace Inc\Base;

use Inc\Base\BaseManager;

/**
* 
*/
class Enqueue extends BaseManager
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	
	function enqueue() {
		// enqueue all our scripts
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_media();
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/build/css/mystyle.css' );
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/build/js/myscript.js' );
	}
}