<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit; 
}

$remove_content = get_option('wpcf_remove_content_after_plugin_removal');

if ($remove_content) {
    delete_option('wpcf_shop_template_override');
    delete_option('wpcf_remove_content_after_plugin_removal');
    delete_option('wcpf_custom_fields');
    delete_option('wcpf_custom_taxonomy');

}