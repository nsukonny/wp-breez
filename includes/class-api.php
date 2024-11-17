<?php
/**
 * Add shortcodes actions
 *
 * @since 1.0.0
 */

namespace WPBreez;

use WPBreez\Framework\Singleton;

defined('ABSPATH') || exit;

class API
{

    use Singleton;

    /**
     * Init post types
     *
     * @since 1.0.0
     */
    public function init()
    {
        add_shortcode('alert-note', array($this, 'alert'));
        add_shortcode('success-note', array($this, 'success'));
        add_shortcode('info-note', array($this, 'info'));
    }

    /**
     * Draw alert note
     *
     * @param $atts
     * @param $content
     *
     * @return false|string
     */
    public function alert($atts, $content)
    {
        ob_start();
        ?>

        <div class="widget__callout-item item-callout item-callout_red">
            <?php if (isset($atts['title'])) { ?>
                <div class="item-callout__title"><?php echo esc_attr($atts['title']); ?></div>
            <?php } ?>
            <div class="item-callout__text">
                <?php echo $content; ?>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Draw success note
     *
     * @param $atts
     * @param $content
     *
     * @return false|string
     */
    public function success($atts, $content)
    {
        ob_start();
        ?>

        <div class="widget__callout-item item-callout item-callout_green">
            <?php if (isset($atts['title'])) { ?>
                <div class="item-callout__title"><?php echo esc_attr($atts['title']); ?></div>
            <?php } ?>
            <div class="item-callout__text">
                <?php echo $content; ?>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Draw success note
     *
     * @param $atts
     * @param $content
     *
     * @return false|string
     */
    public function info($atts, $content)
    {
        ob_start();
        ?>

        <div class="widget__callout-item item-callout item-callout_blue">
            <?php if (isset($atts['title'])) { ?>
                <div class="item-callout__title"><?php echo esc_attr($atts['title']); ?></div>
            <?php } ?>
            <div class="item-callout__text">
                <?php echo $content; ?>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }

}