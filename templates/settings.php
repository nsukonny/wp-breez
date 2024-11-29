<?php

defined('ABSPATH') || exit;

$is_settings = isset($_REQUEST['page']) && 'wpbreez_settings' === $_REQUEST['page'];
$settings = $args['settings'];

if ($is_settings && !empty($_SESSION['notice_success'])) {
    echo '<div class="notice notice-success is-dismissible"><p>' . $_SESSION['notice_success'] . '</p></div>';
    unset($_SESSION['notice_success']);
}

if ($is_settings && !empty($_SESSION['notice_error'])) {
    echo '<div class="notice notice-error is-dismissible"><p>' . $_SESSION['notice_error'] . '</p></div>';
    unset($_SESSION['notice_error']);
}
?>
<div class="wpbreez">

    <h3><?php _e('Импорт', 'wpbreez'); ?></h3>

    <div class="wpbreez-actions">
        <a href="<?php echo admin_url('options-general.php?page=wpbreez_settings&action=import_categories'); ?>"
           class="wpbreez__settings-btn">
            <i class="fa-solid fa-cog"></i>
            <?php _e('1. Импортировать категории', 'wpbreez'); ?>
        </a>
        <a href="<?php echo admin_url('options-general.php?page=wpbreez_settings&action=import_brands'); ?>"
           class="wpbreez__settings-btn">
            <i class="fa-solid fa-cog"></i>
            <?php _e('2. Импортировать бренды', 'wpbreez'); ?>
        </a>
        <a href="<?php echo admin_url('options-general.php?page=wpbreez_settings&action=import_products'); ?>"
           class="wpbreez__settings-btn">
            <i class="fa-solid fa-cog"></i>
            <?php _e('3. Импортировать товары', 'wpbreez'); ?>
        </a>

        <a href="<?php echo admin_url('options-general.php?page=wpbreez_settings&action=import_product_techs'); ?>"
           class="wpbreez__settings-btn">
            <i class="fa-solid fa-cog"></i>
            <?php _e('4. Импортировать аттрибуты товаров', 'wpbreez'); ?>
        </a>

        <a href="<?php echo admin_url('options-general.php?page=wpbreez_settings&action=import_product_stocks'); ?>"
           class="wpbreez__settings-btn">
            <i class="fa-solid fa-cog"></i>
            <?php _e('5. Обновить остатки (обновляются сами каждый несколько часов)', 'wpbreez'); ?>
        </a>
    </div>

    <h3><?php _e('Настройки', 'wpbreez'); ?></h3>

    <div class="wpbreez-settings">
        <form action="<?php echo admin_url('options-general.php?page=wpbreez_settings'); ?>" method="post">
            <?php wp_nonce_field('wpbreeze_save_settings'); ?>
            <label for="api_key"> <?php _e('API Key', 'wpbreez'); ?>
                <input type="text" name="api_key" id="api_key" value="<?php echo esc_attr($settings['api_key']); ?>">
            </label>
            <label for="username"> <?php _e('Логин от Breez', 'wpbreez'); ?>
                <input type="text" id="username" name="username" value="<?php echo esc_attr($settings['username']); ?>">
            </label>
            <label for="passwd"> <?php _e('Пароль', 'wpbreez'); ?>
                <input type="password" id="passwd" name="passwd" value="<?php echo esc_attr($settings['passwd']); ?>">
            </label>
            <p>
                <input type="submit" name="screen-options-apply" id="screen-options-apply" class="button button-primary"
                       value="<?php _e('Сохранить', 'wpbreez'); ?>">
            </p>
        </form>
    </div>
</div>