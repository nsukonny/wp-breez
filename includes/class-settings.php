<?php
/**
 * Draw settings page for admin
 *
 * @since 1.0.0
 */

namespace WPBreez;

use WPBreez\Framework\Singleton;

defined('ABSPATH') || exit;

class Settings
{

    use Singleton;

    /**
     * Init post types
     *
     * @since 1.0.0
     */
    public function init(): void
    {
        if (empty($_REQUEST['page']) || 'wpbreez_settings' !== $_REQUEST['page']) {
            return;
        }

        if (!empty($_REQUEST['action']) && 'import_categories' === $_REQUEST['action']) {
            Import::instance()->import_categories();
            $_SESSION['notice_success'] = 'Категории импортированы';
        }

        if (!empty($_REQUEST['action']) && 'import_brands' === $_REQUEST['action']) {
            Import::instance()->import_category_brands();
            $_SESSION['notice_success'] = 'Бренды импортированы';
        }

        if (!empty($_REQUEST['action']) && 'import_products' === $_REQUEST['action']) {
            $page_number = !empty($_REQUEST['page_number']) ? (int)$_REQUEST['page_number'] : 1;
            Import::instance()->import_products($page_number);
            $_SESSION['notice_success'] = 'Товары импортированы';
        }

        if (!empty($_REQUEST['action']) && 'import_product_techs' === $_REQUEST['action']) {
            Import::instance()->import_all_product_techs();
            $_SESSION['notice_success'] = 'Аттрибуты товаров импортированы';
        }

        if (!empty($_REQUEST['action']) && 'import_product_stocks' === $_REQUEST['action']) {
            Import::instance()->import_product_stocks();
            $_SESSION['notice_success'] = 'Остатки обновлены';
        }

        $this->save_settings();
    }

    /**
     * Save all setting data to option
     *
     * @since 1.0.0
     */
    public function save_settings(): void
    {
        if (!isset($_REQUEST['_wpnonce']) || !isset($_REQUEST['api_key'])) {
            return;
        }

        check_ajax_referer('wpbreeze_save_settings');

        $settings = array(
            'api_key' => sanitize_text_field($_REQUEST['api_key']),
            'username' => sanitize_text_field($_REQUEST['username']),
            'passwd' => sanitize_text_field($_REQUEST['passwd']),
        );

        if (update_option('wpbreez_settings', $settings)) {
            $_SESSION['notice_success'] = 'Настройки сохранены';
            return;
        }

        $_SESSION['notice_error'] = 'Ошибка сохранения настроек';
    }

    /**
     * Draw settings page
     *
     * @since 1.0.0
     */
    public function draw_settings(): void
    {
        load_template(WPBREEZ_PATH . 'templates/settings.php', true, array('settings' => self::get_settings()));
    }

    /**
     * Get settings from wp options and set default if need it
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function get_settings(): array
    {
        $settings = get_option('wpbreez_settings');

        return $settings ?: array();
    }

}
