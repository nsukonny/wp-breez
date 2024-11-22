<?php
/**
 * Init all plugin
 *
 * @since 1.0.0
 */

namespace WPBreez;

use WPBreez\Framework\Singleton;

defined('ABSPATH') || exit;

class WPBreez
{

    use Singleton;

    /**
     * Init core of the plugin
     *
     * @since 1.0.0
     */
    public function init()
    {
        add_action('init_wpbreez', array(API::class, 'instance'));
        add_action('init_wpbreez', array(Import::class, 'instance'));
        add_action('init_wpbreez', array(Settings::class, 'instance'));

        if (is_admin()) {
            add_action('init_wpbreez', array($this, 'admin_init'));
        }

        do_action('init_wpbreez');
        do_action('after_init_wpbreez');
    }

    /**
     * Init functionality just for admin side
     *
     * @since 1.0.0
     */
    public function admin_init()
    {
        add_action('init_wpbreez_admin', array(Menu::class, 'instance'));

        do_action('init_wpbreez_admin');
    }

}
