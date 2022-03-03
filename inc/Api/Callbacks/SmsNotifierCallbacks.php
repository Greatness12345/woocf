<?php
/**
 * @package  AlecadddPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseManager;

class SmsNotifierCallbacks extends BaseManager
{
    public function shortcodePage()
    {
        return require_once( "$this->plugin_path/templates/testimonial.php" );
    }
}
