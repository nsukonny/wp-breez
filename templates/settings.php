<?php
defined( 'ABSPATH' ) || exit;

$is_settings = isset( $_REQUEST['page'] ) && 'wpbreez_settings' === $_REQUEST['page'];
$settings    = $args['settings'];
?>
    <div class="widget">

        <div class="widget-panel">

            <div id="widgetMainBody"
                 class="widget-panel__content body-widget<?php if ( $is_settings ) { ?> widget_showed<?php } ?>">

				<?php load_template( WPBREEZ_PATH . 'templates/settings/tabs.php', true, $args ); ?>

                <div class="body-widget__content content-widget">

                    <form action="#" name="wpbreez_setting_form" method="post" novalidate >

                        <input type="hidden" name="_ajax_nonce"
                               value="<?php echo esc_attr( wp_create_nonce( '_wpbreez_nonce' ) ); ?>">

						<?php
						$setting_tabs = array(
							'visibility',
							'placement',
							'buttons',
							'widget_style',
							'header',
							'form',
							'feedback',
						);
						foreach ( $setting_tabs as $setting_tab ) {
							load_template( WPBREEZ_PATH . 'templates/settings/' . $setting_tab . '.php', true, $args );
						}
						?>

                        <div class="field-widget__cls-line"></div>
                        <div class="field-widget__save-btn-container">
                            <button class="field-widget__save-options save-settings">
                                <img src="<?php echo WPBREEZ_URL; ?>assets/img/preloader.svg"
                                     class="widget-preloader hidden">
                                <i class="fa-solid fa-check widget-preloader__complete hidden"></i><?php _e( 'Save options', 'wpbreez' ); ?>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

            <?php
			load_template( WPBREEZ_PATH . 'templates/settings/modals/add_url_modal.php', true, $args );
			load_template( WPBREEZ_PATH . 'templates/settings/modals/add_form_field_modal.php', true, $args );
			?>

        </div>
    </div>

<?php wp_enqueue_media(); ?>