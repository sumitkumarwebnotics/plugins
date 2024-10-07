<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook into 'admin_init' to check for specific plugin actions when an admin page is loaded. And for auto update enable and disable.
add_action( 'admin_init', function() {
    if ( ! empty( $_GET['action'] ) && ! empty( $_GET['plugin'] ) && current_user_can( 'update_plugins' ) ) {
        $action = $_GET['action'];
        $plugin = $_GET['plugin'];

        if ( $plugin === WCPFCF_PLUGIN_BASENAME ) {
            if ( $action === 'enable_auto_update' && check_admin_referer( 'enable-auto_update_' . $plugin ) ) {
                update_option( WCPFCF_Advanced_Product_Filter::OPTION_AUTO_UPDATE_ENABLED, true );
                wp_redirect( admin_url( 'plugins.php' ) );
                exit;
            } elseif ( $action === 'disable_auto_update' && check_admin_referer( 'disable-auto_update_' . $plugin ) ) {
                update_option( WCPFCF_Advanced_Product_Filter::OPTION_AUTO_UPDATE_ENABLED, false );
                wp_redirect( admin_url( 'plugins.php' ) );
                exit;
            }
        }
    }
});