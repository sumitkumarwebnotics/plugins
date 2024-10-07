<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WCPFCF_Advanced_Product_Filter' ) ) {

    class WCPFCF_Advanced_Product_Filter {

        const OPTION_AUTO_UPDATE_ENABLED = 'wcpfcf_auto_update_enabled';

        /**
         * Constructor
         * Initializes the plugin
         */
        public function __construct() {
            // Register plugin activation and update hooks
            register_activation_hook( __FILE__, array( $this, 'on_activation' ) );
            add_action( 'upgrader_process_complete', array( $this, 'on_update' ), 10, 2 );

            // Initialize auto-update
            add_filter( 'auto_update_plugin', array( $this, 'maybe_enable_auto_update' ), 10, 2 );

            // Add filter to control auto-update column in the plugins list
            add_filter( 'plugin_auto_update_setting_html', array( $this, 'auto_update_setting_html' ), 10, 3 );
        }

        /**
         * Runs on plugin activation.
         */
        public function on_activation() {
            // Enable auto-update option by default
            update_option( self::OPTION_AUTO_UPDATE_ENABLED, true );
        }

        /**
         * Runs on plugin update.
         *
         * @param WP_Upgrader $upgrader The upgrader object.
         * @param array       $hook_extra The information about the updated plugin.
         */
        public function on_update( $upgrader, $hook_extra ) {
            if ( isset( $hook_extra['type'] ) && $hook_extra['type'] === 'plugin' ) {
                foreach ( $hook_extra['plugins'] as $plugin ) {
                    if ( $plugin === WCPFCF_PLUGIN_BASENAME ) {
                        // Preserve or reset auto-update settings as needed
                        update_option( self::OPTION_AUTO_UPDATE_ENABLED, true );
                    }
                }
            }
        }

        /**
         * Enable automatic updates if the option is enabled.
         *
         * @param bool   $update 
         * @param object $item 
         * @return bool 
         */
        public function maybe_enable_auto_update( $update, $item ) {
            if ( isset( $item->plugin ) && $item->plugin === WCPFCF_PLUGIN_BASENAME ) {
                $auto_update_enabled = get_option( self::OPTION_AUTO_UPDATE_ENABLED, true );
                return $auto_update_enabled;
            }
            return $update;
        }

        /**
         * Modify the "Automatic Updates" column in the Plugins page.
         *
         * @param string $html 
         * @param string $plugin_file 
         * @param array  $plugin_data 
         * @return string 
         */
        public function auto_update_setting_html( $html, $plugin_file, $plugin_data ) {
            if ( $plugin_file === WCPFCF_PLUGIN_BASENAME ) {
                $auto_update_enabled = get_option( self::OPTION_AUTO_UPDATE_ENABLED, true );
                if ( $auto_update_enabled ) {
                    $html = '<a href="' . wp_nonce_url( 'plugins.php?action=disable_auto_update&plugin=' . $plugin_file, 'disable-auto_update_' . $plugin_file ) . '">' . __( 'Disable auto-updates' ) . '</a>';
                } else {
                    $html = '<a href="' . wp_nonce_url( 'plugins.php?action=enable_auto_update&plugin=' . $plugin_file, 'enable-auto_update_' . $plugin_file ) . '">' . __( 'Enable auto-updates' ) . '</a>';
                }
            }

            return $html;
        }

        /**
         * Initialize the plugin.
         */
        public static function init() {
            $instance = new self();
        }
    }
}
