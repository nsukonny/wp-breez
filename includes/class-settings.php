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
    public function init()
    {
        add_action('wp_ajax_wpbreez_save_form', array($this, 'save_form'));

        add_filter('wp_check_filetype_and_ext', array($this, 'enable_svg'), 10, 4);
        add_filter('upload_mimes', array($this, 'add_svg_mime_types'));
    }

    /**
     * Save all setting data to option
     *
     * @since 1.0.0
     */
    public function save_form(): void
    {
        check_ajax_referer('_wpbreez_nonce');

        $settings = $this->sanitize_array($_REQUEST['form_data']);
        unset($settings['_ajax_nonce']);

        $settings = $this->parse_urls($settings); //TODO Move this to filter hp_save_settings
        $settings = $this->add_checkboxes($settings);
        $settings = $this->remove_empty_form_fields($settings);

        if (update_option('wpbreez_settings', apply_filters('hp_save_settings', $settings))) {
            wp_send_json_success();
        }

        wp_send_json_error();
    }

    /**
     * Draw settings page
     *
     * @since 1.0.0
     */
    public function draw_settings()
    {
        load_template(WPBREEZ_PATH . 'templates/settings.php', true, array('settings' => self::get_settings()));
    }

    /**
     * Sanitize incoming array
     *
     * @param $array
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    private function sanitize_array(&$array)
    {
        foreach ($array as &$value) {
            if ( ! is_array($value)) {
                $value = sanitize_text_field($value);
            } else {
                $this->sanitize_array($value);
            }
        }

        return $array;
    }

    /**
     * Convert display_rule_urls[1] to array
     *
     * @param $settings
     *
     * @return array
     *
     * @since 1.0.0
     */
    private function parse_urls($settings)
    {
        $display_rule_urls = array();

        foreach ($settings as $key => $setting) {
            if ('display_rule_urls' === substr($key, 0, 17)) {
                if ( ! empty($setting['url'])) {
                    $display_rule_urls[] = $setting;
                }

                unset($settings[$key]);
            }
        }

        $settings['display_rule_urls'] = $display_rule_urls;

        return $settings;
    }

    /**
     * Get settings from wp options and set default if need it
     *
     * @since 1.0.0
     */
    public function get_settings()
    {
        $settings = get_option('wpbreez_settings');

        if ( ! is_array($settings)) {
            $settings = array();
        }

        return array_merge(self::get_default_settings(), $settings);
    }

    /**
     * Get default settings
     *
     * @return array
     *
     * @since 1.0.0
     */
    private static function get_default_settings()
    {
        return array(
            'enabled'                     => '0',
            'display_rule'                => 'all',
            'placement_position'          => 'right',
            'placement_side_margin'       => '10',
            'placement_bottom_margin'     => '25',
            'widget_button_view'          => 'icon',
            'widget_button_border_radius' => '15',
            'widget_button_text'          => 'Help',
            'color_header'                => '#FFFFFF',
            'color_header_bg'             => '#485AFF',
            'margin_top'                  => '10',
            'widget_button_icon'          => 'fas fa-question-circle',
            'widget_button_icon_aid'      => '',
            'color_widget_icon_bg'        => '#485AFF',
            'color_widget_icon'           => '#FFFFFF',
            'widget_close_icon'           => 'fas fa-times',
            'widget_close_icon_aid'       => '',
            'widget_search_icon'          => 'fas fa-search',
            'widget_search_icon_aid'      => '',
            'color_widget_close_icon_bg'  => '#485AFF',
            'color_widget_close_icon'     => '#FFFFFF',
            'color_widget_search_icon_bg' => '#485AFF',
            'color_widget_search_icon'    => '#FFFFFF',
            'logo'                        => 'off',
            'logo_img'                    => '',
            'header_name'                 => '',
            'header_title'                => __('Hey there! 👋', 'wpbreez'),
            'header_contact'              => __('Contact Us', 'wpbreez'),
            'header_subtitle'             => __(
                'Read through our docs, if you have any questions or queries, please contact us right away!',
                'wpbreez'
            ),
            'form_enabled'                => 'form',
            'form_btn_border_radius'      => 27,
            'form_btn_color_bg'           => '#485AFF',
            'form_btn_color'              => '#FFFFFF',
            'form_ask_recaptcha'          => 'no',
            'form_recaptcha_public_key'   => '',
            'form_recaptcha_private_key'  => '',
            'form'                        => array(
                'email'           => get_option('admin_email'),
                'btn_text'        => __('Send Message', 'wpbreez'),
                'success_message' => __(
                    'Thank you for your message! We will get back to you as soon as possible.',
                    'wpbreez'
                ),
                'welcome_message' => __(
                    'Let us know if you have any question or query.',
                    'wpbreez'
                ),
            ),
            'display_rule_urls'           => array(),
            'feedback_title'              => __('Was this helpful?', 'wpbreez'),
            'feedback_success'            => __('Thank you for your feedback!', 'wpbreez'),
            'question_good_icon'          => 'far fa-thumbs-up',
            'question_good_icon_aid'      => '',
            'question_bad_icon'           => 'far fa-thumbs-down',
            'question_bad_icon_aid'       => '',
        );
    }

    /**
     * Activate SVG support
     *
     * @param $data
     * @param $file
     * @param $filename
     * @param $mimes
     *
     * @return array|mixed
     *
     * @since 1.0.0
     */
    public function enable_svg($data, $file, $filename, $mimes)
    {
        global $wp_version;
        if ('4.7.1' !== $wp_version) {
            return $data;
        }

        $filetype = wp_check_filetype($filename, $mimes);

        return array(
            'ext'             => $filetype['ext'],
            'type'            => $filetype['type'],
            'proper_filename' => $data['proper_filename'],
        );
    }

    /**
     * Add new mime type for svg
     *
     * @param $mimes
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    public function add_svg_mime_types($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';

        return $mimes;
    }

    /**
     * Fix thumbnail resolution for svg
     *
     * @since 1.0.0
     */
    public function add_svg_thumbnail_size()
    {
        ?>
        <style type="text/css">
					.attachment-266x266, .thumbnail img {
						width: 100% !important;
						height: auto !important;
					}
        </style>
        <?php
    }

    /**
     * Check if uploaded file s image
     *
     * @param $url
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public static function is_image($url)
    {
        $ext             = array('gif', 'jpg', 'jpeg', 'png', 'svg');
        $image_extension = pathinfo($url, PATHINFO_EXTENSION);

        return in_array($image_extension, $ext, true);
    }

    /**
     * Check if this attachment number
     *
     * @param $thumbnail_id
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public static function is_thumbnail_id($thumbnail_id)
    {
        return is_numeric($thumbnail_id);
    }

    /**
     * Mark all yes/no parameters to no if they not have yes
     *
     * @param array $settings
     *
     * @return array
     *
     * @since 1.0.0
     */
    private function add_checkboxes(array $settings)
    {
        $checkboxes = array(
            'enabled',
            'logo',
            'form_ask_recaptcha',
        );

        foreach ($checkboxes as $checkbox) {
            if ( ! isset($settings[$checkbox])) {
                $settings[$checkbox] = 'no';
            }
        }

        return $settings;
    }

    /**
     * Clear all empty fields from settings
     *
     * @param array $settings
     *
     * @return array
     *
     * @since 1.0.0
     */
    private function remove_empty_form_fields(array $settings)
    {
        if (isset($settings['form']['fields']) && is_array($settings['form']['fields'])) {
            foreach ($settings['form']['fields'] as $field_key => $field) {
                if (empty($field['name'])) {
                    unset($settings['form']['fields'][$field_key]);
                }
            }
        }

        return $settings;
    }

    /**
     * Get current ID for user or remember this for one year
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function get_current_user_id()
    {
        if (is_user_logged_in()) {
            return get_current_user_id();
        }

        if (isset($_COOKIE['tmp_user_id'])) {
            return $_COOKIE['tmp_user_id'];
        }

        $tmp_user_id = substr(uniqid(wp_rand(0, 999999), true), 0, 8);
        setcookie('tmp_user_id', $tmp_user_id, strtotime('+1 year'), COOKIEPATH, COOKIE_DOMAIN);

        return $tmp_user_id;
    }

}
