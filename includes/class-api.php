<?php
/**
 * Work with API requests
 *
 * @since 1.0.0
 */

namespace WPBreez;

use WPBreez\Framework\Singleton;

defined('ABSPATH') || exit;

class API
{

    use Singleton;

    private $api_url = 'https://api.breez.ru/v1/';

    /**
     * Init post types
     *
     * @since 1.0.0
     */
    public function init()
    {
    }

    /**
     * Get all categories
     *
     * @since 1.0.0
     */
    public function get_breez_categories(): array
    {
        $breez_categories = get_transient('breez_categories');
        if (false === $breez_categories) {
            $breez_categories = $this->get_response('categories');
            set_transient('breez_categories', $breez_categories, 1 * HOUR_IN_SECONDS);
        }

        return $breez_categories;
    }

    /**
     * Get technical data for the category
     *
     * @since 1.0.0
     */
    public function get_breez_category_tech($breez_category_id): array
    {
        return $this->get_response('tech/?category=' . $breez_category_id);
    }

    /**
     * Get all products
     *
     * @since 1.0.0
     */
    public function get_breez_products(): array
    {
        $breez_products = get_transient('breez_products');
        if (false === $breez_products) {
            $breez_products = $this->get_response('products');
            set_transient('breez_products', $breez_products, 1 * HOUR_IN_SECONDS);
        }

        return $breez_products;
    }

    /**
     * Get technical data for the product
     *
     * @since 1.0.0
     */
    public function get_breez_product_tech($breez_product_id): array
    {
        return $this->get_response('tech/?id=' . $breez_product_id);
    }

    /**
     * Get all categories
     *
     * @since 1.0.0
     */
    public function get_breez_brands(): array
    {
        $breez_brands = get_transient('breez_brands');
        if (false === $breez_brands) {
            $breez_brands = $this->get_response('brands');
            set_transient('breez_brands', $breez_brands, 1 * HOUR_IN_SECONDS);
        }

        return $breez_brands;
    }

    /**
     * Get stocks for products
     *
     * @since 1.0.0
     */
    public function get_breez_products_stocks(): array
    {
        $breez_products_stocks = get_transient('breez_products_stocks');
        if (false === $breez_products_stocks) {
            $breez_products_stocks = $this->get_response('leftovers');
            set_transient('breez_products_stocks', $breez_products_stocks, 1 * HOUR_IN_SECONDS);
        }

        return $breez_products_stocks;
    }

    /**
     * DO a call to the server and get the response
     *
     * @param $url
     *
     * @return array
     */
    private function get_response($url): array
    {
        $username = 'splitmontazhkmv@yandex.ru'; //TODO move to settings
        $password = 'e48febdb77e24c6f9607';
        $api_key = 'c3BsaXRtb250YXpoa212QHlhbmRleC5ydTplNDhmZWJkYjc3ZTI0YzZmOTYwNw==';

        $credentials = base64_encode("$username:$password");
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . $credentials,
            ),
        );

        $response = wp_remote_get($this->api_url . $url, $args);
        if (is_wp_error($response)) {
            error_log('API Error: ' . $response->get_error_message());
            return [];
        }

        $response_body = wp_remote_retrieve_body($response);
        error_log("API Response: " . print_r($response_body, true));

        $data = json_decode($response_body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('JSON decode error: ' . json_last_error_msg());
            return [];
        }

        return $data;
    }

}