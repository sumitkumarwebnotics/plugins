<?php
/**
 * Plugin Name: WooCustomFilter — by Webnotics  
 * Plugin URI: 
 * Description: This plugin allows customers to filter products based on custom fields and taxonomies, providing a tailored shopping experience and boosting discoverability of your products.
 * Version: 1.0
 * Author: Webnotics Pvt Ltd.
 * Author URI: https://webnotics.solutions/
 * Text Domain: Product filter
 * Domain Path: /languages
 * WC requires at least: 5.3
 * WC tested up to: 8.0.2
 **/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once ABSPATH . 'wp-admin/includes/plugin.php';

// WCPFCF meaning : woo-commerce product filter custom field
define('PRODUCT_FILTER_PREFIX', 'WCPFCF');
define('WCPFCF_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('WCPFCF_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('WCPFCF_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Check if WooCommerce is active
if (is_plugin_active('woocommerce/woocommerce.php')) {

    require_once(WCPFCF_PLUGIN_DIR_PATH . 'admin/class-woo-custom-filter-by-webnotics-admin.php');
    // Setting action for plugin
    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'WC_my_custom_plugin_action_links');

    function WC_my_custom_plugin_action_links($links)
    {
        $links[] = '<a href="' . site_url() . '/wp-admin/admin.php?page=woo-custom-filter"><?= __("Settings","woo-custom-filter-by-webnotics"); ?></a>';
        $links[] = '<a href="' . site_url() . '/wp-admin/admin.php?page=woo-custom-filter-documentation"><?= __("Documentation","woo-custom-filter-by-webnotics"); ?></a>';
        return $links;
    }

} else {
    // Show admin notice and prevent further code execution
    add_action('admin_notices', 'WCPFCF_custom_admin_notice');

    // check WCPFCF_custom_admin_notice function exist or not
    if (!function_exists('WCPFCF_custom_admin_notice')) {
        function WCPFCF_custom_admin_notice()
        {
            ?>
            <div class="notice notice-error">
                <p><?= __("Your product filter based on custom field and custom taxonomy for WooCommerce plugin requires WooCommerce to be installed and active.","woo-custom-filter-by-webnotics"); ?>
                </p>
            </div>
            <?php
        }

    }
}


// Include the main plugin class file
require_once WCPFCF_PLUGIN_DIR_PATH . 'includes/wcpfcf-check-update-auto-enables.php';

// Initialize the plugin - includes/wcpfcf-check-update-auto-enables.php
if (class_exists('WCPFCF_Advanced_Product_Filter')) {
    add_action('plugins_loaded', array('WCPFCF_Advanced_Product_Filter', 'init')); 
}


// Include the submission form auto-update in wp-options
require_once WCPFCF_PLUGIN_DIR_PATH . 'includes/wcpfcf-form-submissions-update-auto-enables.php';

if (class_exists('WCPFCF_Plugin')) {
 // Register activation hook
 $wcpfcf_plugin = new WCPFCF_Plugin();
 register_activation_hook(__FILE__, [$wcpfcf_plugin,'WCPFCF_plugin_activate']);

 // Register deactivation hook
 register_deactivation_hook(__FILE__, [$wcpfcf_plugin,'WCPFCF_plugin_deactivate']);
}

// for high order option settings
add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );

/**
 * Loads the plugin's textdomain for localization.
 * 
 * This function is responsible for loading the translation files 
 * from the 'languages' directory, enabling the plugin to support multiple languages.
 * It uses the 'woo-custom-filter-by-webnotics' text domain.
 * The function is hooked to the 'plugins_loaded' action, ensuring that
 * all active plugins are initialized before loading the translations.
 */
function woo_custom_filter_by_webnotics_load_textdomain() {
    load_plugin_textdomain('woo-custom-filter-by-webnotics', false, dirname(plugin_basename(__FILE__)) . '/languages');

}
add_action( 'plugin_loaded', 'woo_custom_filter_by_webnotics_load_textdomain' );




 



