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
     * @return void
     *
     * @since 1.0.0
     */
    public function init(): void
    {
        add_action('init_wpbreez', array(Settings::class, 'instance'));
        add_action('init_wpbreez', array(API::class, 'instance'));
        add_action('init_wpbreez', array(Import::class, 'instance'));
        add_action('init_wpbreez', array(Cron::class, 'instance'));

        if (is_admin()) {
            add_action('init_wpbreez', array($this, 'admin_init'));
        }

        do_action('init_wpbreez');
        do_action('after_init_wpbreez');
    }

    /**
     * Init functionality just for admin side
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function admin_init(): void
    {
        add_action('init_wpbreez_admin', array(Menu::class, 'instance'));
        //add_action('init_wpbreez_admin', array(Cron::class, 'instance'));

        do_action('init_wpbreez_admin');
    }

}
