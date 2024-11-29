<?php
/**
 * Install and uninstall actions
 *
 * @since 1.0.0
 */

namespace WPBreez;

use WPBreez\Framework\Singleton;

defined('ABSPATH') || exit;

class Install
{

    /**
     * Actions for install the plugin
     * Called once
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function activation(): void
    {
        self::wpbreez_activate();
    }

    /**
     * Call on uninstall the plugin
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function uninstall(): void
    {
    }

    /**
     * Call on deactivation the plugin
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function deactivate(): void
    {
        self::wpbreez_deactivate();
    }

    /**
     * Call on activate the plugin
     *
     * @return void
     */
    public static function wpbreez_activate(): void
    {
        if (!wp_next_scheduled('wpbreez_update_stocks')) {
            wp_schedule_event(time(), 'hourly', 'wpbreez_update_stocks');
        }
    }

    /**
     * Call on deactivate the plugin
     *
     * @return void
     */
    public static function wpbreez_deactivate(): void
    {
        $timestamp = wp_next_scheduled('wpbreez_update_stocks');
        if ($timestamp) {
            wp_unschedule_event($timestamp, 'wpbreez_update_stocks');
        }
    }
}
