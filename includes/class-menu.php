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
    public function init(): void
    {
        add_action('admin_menu', array($this, 'add_menu_page'));
    }

    /**
     * Add link to menu
     *
     * @since 1.0.0
     */
    public function add_menu_page(): void
    {
        add_submenu_page(
            'options-general.php',
            __('WPBreez Settings', 'wpbreez'),
            __('WPBreez Settings', 'wpbreez'),
            'manage_options',
            'wpbreez_settings',
            array(Settings::instance(), 'draw_settings')
        );
    }

}

add_action('init_wpbreez_admin', array(Menu::class, 'instance'));