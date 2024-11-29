<?php
/**
 * Cron tasks
 *
 * @since 1.0.0
 */

namespace WPBreez;

use WPBreez\Framework\Singleton;

defined('ABSPATH') || exit;

class Cron
{

    use Singleton;

    /**
     * Init post types
     *
     * @since 1.0.0
     */
    public function init(): void
    {
        add_action('wpbreez_update_stocks', array($this, 'update_stocks'));
    }

    /**
     * Update stocks by cron task
     *
     */
    public function update_stocks(): void
    {
        Import::instance()->import_product_stocks();
    }

}