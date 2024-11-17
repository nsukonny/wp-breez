<?php
/**
 * Menu in the left side
 *
 * @since 1.0.0
 */

namespace WPBreez;

use WPBreez\Framework\Singleton;

defined('ABSPATH') || exit;

class Menu
{

    use Singleton;

    /**
     * Init post types
     *
     * @since 1.0.0
     */
    public function init()
    {
        add_action('admin_menu', array($this, 'add_menu_page'));
        add_action('admin_menu', array($this, 'remove_submenu_page'));
    }

    /**
     * Add link to menu
     *
     * @since 1.0.0
     */
    public function add_menu_page()
    {
        add_submenu_page(
            'edit.php?post_type=wpbreez',
            __('Settings', 'wpbreez'),
            __('Settings', 'wpbreez'),
            'manage_options',
            'wpbreez_settings',
            array(Settings::instance(), 'draw_settings')
        );
    }

    /**
     * Hide doubles from the menu
     *
     * @since 1.0.0
     */
    public function remove_submenu_page()
    {
        remove_submenu_page('wpbreez', 'wpbreez');
    }

}

add_action('init_wpbreez', array(Menu::class, 'instance'));