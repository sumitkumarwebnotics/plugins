<?php


if (!class_exists('WCPFCF_Admin')) {
class WCPFCF_Admin {

    public function __construct() {
        add_action('admin_menu', [$this, 'wcpf_admin_menu']);
    }

     /**
     * Register the admin menu and submenu pages.
     *
     * This function adds the main menu and several submenu pages to the WordPress admin dashboard
     * for the WooCustomFilter plugin. It includes pages for managing custom fields, taxonomies, settings,
     * documentation, and other specific tasks like adding and updating custom fields and taxonomies.
     *
     * @return void
     */
    public function wcpf_admin_menu()
    {
        add_menu_page(
            __('WooCustomFilter', 'woo-custom-filter-by-webnotics'),
            __('WooCustomFilter', 'woo-custom-filter-by-webnotics'),
            'manage_options',
            'woo-custom-filter',
            [$this, 'wcpf_admin_page_contents'],
            'dashicons-schedule',
            3
        );
        add_submenu_page(
            'woo-custom-filter',
            __('All Custom Field', 'woo-custom-filter-by-webnotics'),
            __('All Custom Field', 'woo-custom-filter-by-webnotics'),
            'manage_options',
            'all-custom-fields',
            [$this, 'wcpf_all_custom_fields_page']
        );
        add_submenu_page(
            'woo-custom-filter',
            __('All Taxonomies Field', 'woo-custom-filter-by-webnotics'),
            __('All Taxonomies Field', 'woo-custom-filter-by-webnotics'),
            'manage_options',
            'all-taxonomies',
            [$this, 'wcpf_all_taxonomies_page']
        );

        add_submenu_page(
            'woo-custom-filter',
            __('Settings', 'woo-custom-filter-by-webnotics'),
            __('Settings', 'woo-custom-filter-by-webnotics'),
            'manage_options',
            'woo-custom-filter-settings',
            [$this, 'wcpf_custom_filter_settings_page']
        );

        add_submenu_page(
            'woo-custom-filter',
            __('Documentation', 'woo-custom-filter-by-webnotics'),
            __('Documentation', 'woo-custom-filter-by-webnotics'),
            'manage_options',
            'woo-custom-filter-documentation',
            [$this, 'wcpf_custom_filter_documentation_page']
        );
        add_submenu_page(
            '.',
            __('Add New Custom Field', 'woo-custom-filter-by-webnotics'),
            __('Add New Custom Field', 'woo-custom-filter-by-webnotics'),
            'manage_options',
            'add_new_custom_field',
            [$this, 'wcpf_add_new_custom_field_page']
        );
        add_submenu_page(
            '.',
            __('Update Custom Field', 'woo-custom-filter-by-webnotics'),
            __('Update Custom Field', 'woo-custom-filter-by-webnotics'),
            'manage_options',
            'update_value_custom_field',
            [$this, 'wcpf_update_value_custom_field_page']
        );
        add_submenu_page(
            '.',
            __('Add New Taxonomy', 'woo-custom-filter-by-webnotics'),
            __('Add New Taxonomy', 'woo-custom-filter-by-webnotics'),
            'manage_options',
            'add_new_custom_taxonomy',
            [$this, 'wcpf_add_new_custom_taxonomy_page']
        );
        


    }


    
     
    /**
     * Display the content of the main admin page for the WooCustomFilter plugin.
     *
     * This function includes the necessary PHP file that contains the settings and content 
     * for the main admin page of the WooCustomFilter plugin.
     *
     * @return void
     */
    public function wcpf_admin_page_contents()
    {
        require_once(WCPFCF_PLUGIN_DIR_PATH . 'admin/includes/custom_filter_setting.php');
    }

    /**
     * Display the custom fields settings page for the WooCustomFilter plugin.
     *
     * This function includes the PHP file that handles to display custom field list and have ability to delete or update feaures.
     *
     * @return void
     */
    public function wcpf_all_custom_fields_page()
    {
        require_once(WCPFCF_PLUGIN_DIR_PATH . 'admin/includes/all_custom_fields.php');
    }

    /**
     * Display the taxonomies fields settings page for the WooCustomFilter plugin.
     *
     * This function includes the PHP file that handles the taxonomies and have ability to delete or update feaures.
     * for the taxonomies fields settings page in the WooCustomFilter plugin.
     *
     * @return void
     */
    public function wcpf_all_taxonomies_page()
    {
        require_once(WCPFCF_PLUGIN_DIR_PATH . 'admin/includes/all_taxonomies_fields.php');
    }

    /**
     * Display the custom filter settings page for the WooCustomFilter plugin.
     *
     * This function includes the PHP file that handles the content and settings
     * for the custom filter settings page in the WooCustomFilter plugin.
     *
     * @return void
     */
    public function wcpf_custom_filter_settings_page()
    {
        require_once(WCPFCF_PLUGIN_DIR_PATH . 'admin/includes/wcpf_custom_filter_settings_page.php');
    }

     /**
     * Display the documentation page for the WooCustomFilter plugin.
     *
     * This function includes the PHP file that handles the content and documentation
     * for the WooCustomFilter plugin. It is used to provide users with information 
     * about the plugin's features, usage, and guidelines.
     *
     * @return void
     */
    public function wcpf_custom_filter_documentation_page()
    {
        require_once(WCPFCF_PLUGIN_DIR_PATH . 'admin/includes/documentation.php');
    }

    /**
     * Display the page for adding a new custom field.
     *
     * This function includes the PHP file that provides the form and functionality
     * for adding a new custom field to the WooCustomFilter plugin. It is used to 
     * allow users to create and configure new custom fields for the plugin.
     *
     * @return void
     */
    public function wcpf_add_new_custom_field_page()
    {
        require_once(WCPFCF_PLUGIN_DIR_PATH . 'admin/includes/add_new_custom_field.php');
    }

    /**
     * Display the page for updating an existing custom field.
     *
     * This function includes the PHP file that provides the form and functionality
     * for updating an existing custom field within the WooCustomFilter plugin. It
     * allows users to modify the settings and details of custom fields that have
     * already been created.
     *
     * @return void
     */
    public function wcpf_update_value_custom_field_page()
    {
        require_once(WCPFCF_PLUGIN_DIR_PATH . 'admin/includes/update_custom_field.php');
    }

    /**
     * Display the page for adding a new custom taxonomy.
     *
     * This function includes the PHP file that provides the form and functionality
     * for adding a new custom taxonomy within the WooCustomFilter plugin. It allows
     * users to create and configure new taxonomies to be used for filtering products.
     *
     * @return void
     */
    public function wcpf_add_new_custom_taxonomy_page()
    {
        require_once(WCPFCF_PLUGIN_DIR_PATH . 'admin/includes/add_new_custom_taxonomy.php');
    }
    
}

}
new WCPFCF_Admin();



