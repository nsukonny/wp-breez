<?php
/**
 * Plugin Name: WP Breez
 * Plugin URI: nsukonny.agency/wp-breeze
 * Description: Integrate Breez.ru API with your WordPress website.
 * Version: 1.0.0
 * Author: WPBreez
 * Author URI: nsukonny.agency
 * Text Domain: wpbreez
 * Domain Path: /languages
 */

namespace WPBreez;

use WPBreez\Framework\Loader;

defined('ABSPATH') || exit;
define('WPBREEZ_PATH', plugin_dir_path(__FILE__));
define('WPBREEZ_URL', plugin_dir_url(__FILE__));
define('WPBREEZ_VERSION', '1.0.0');
define('WPBREEZ_FEATURES', array('ajax_loader'));

require_once plugin_dir_path(__FILE__) . 'includes/framework/trait-singleton.php';
require_once plugin_dir_path(__FILE__) . 'includes/framework/class-loader.php';

Loader::init_autoload(__NAMESPACE__, __DIR__);
register_activation_hook(__FILE__, array(Install::class, 'install'));

if (is_admin()) {
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        add_action('init', array(WPBreez::class, 'instance'));
    } else {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error is-dismissible">
                <p>' . __('WP Breez requires WooCommerce plugin to be active.', 'wpbreez') . '</p>
            </div>';
        });
    }
}
