<?php

if (!class_exists('WCPFCF_Plugin')) {
    class WCPFCF_Plugin {

        public function __construct() {
            $this->include_files();
        }

        /**
         * Include necessary files for the plugin's functionality.
         *
         * This function loads various classes and hooks required by the plugin. 
         * It ensures that the admin menu, scripts, settings, AJAX hooks, 
         * custom taxonomies, product edit page hooks, and shortcodes are properly included.
         *
         * @return void
        */
        private function include_files() {
            require_once WCPFCF_PLUGIN_DIR_PATH . 'admin/classes/class-wcpf-admin_menu.php';
            require_once WCPFCF_PLUGIN_DIR_PATH . 'admin/classes/class-wcpf-scripts.php';
            require_once WCPFCF_PLUGIN_DIR_PATH . 'admin/classes/class-wcpf-settings.php';
            require_once WCPFCF_PLUGIN_DIR_PATH . 'admin/hooks/wcpf_wp_ajax_hooks.php';
            require_once WCPFCF_PLUGIN_DIR_PATH . 'admin/hooks/wcpf_register_taxonomies.php';
            require_once WCPFCF_PLUGIN_DIR_PATH . 'admin/hooks/wcpf_product_edit_page_hooks.php';
            require_once WCPFCF_PLUGIN_DIR_PATH . 'public/shortcodes/wcpf_shortcodes_shop_page_sidebar.php';
        }
        

        /**
         * Plugin activation hook.
         *
         * This function is triggered when the plugin is activated. It can be used to
         * perform initial setup tasks such as creating default options, setting up 
         * custom database tables, or any other necessary initialization.
         *
         * Currently, the function is empty, but it can be filled with code to 
         * handle activation-related tasks.
         *
         * @return void
        */
        public function WCPFCF_plugin_activate()
        {

        }

        /**
         * Plugin deactivation hook.
         *
         * This function is triggered when the plugin is deactivated. It can be used to
         * perform cleanup tasks such as removing options, custom database tables, or 
         * other plugin-specific data.
         *
         * In this case, it checks if the 'remove content' option is enabled. If it is,
         * the function deletes certain options related to the plugin's content removal.
         *
         * @return void
        */
        public function WCPFCF_plugin_deactivate()
        {


            // $remove_content = get_option('wpcf_remove_content_after_plugin_removal');

            // if ($remove_content) {
            //     delete_option('wpcf_shop_template_override');
            //     delete_option('wpcf_remove_content_after_plugin_removal');

            // }


        }



    }


     
}
