<?php
if (!class_exists('WCPFCF_Register_taxonomy')) {
    class WCPFCF_Register_taxonomy
    {

        public function __construct()
        {
            add_action('init', [$this, 'wcpf_register_taxonomies']);
        }



        /*---------------------------------------------*/
        /*         For register custom taxonomy        */
        /*---------------------------------------------*/

        /**
         * Register custom taxonomies for the plugin.
         *
         * This function is responsible for registering one or more custom taxonomies
         * that will be used within the plugin. Custom taxonomies allow you to group content
         * in a more structured way, beyond the default categories and tags in WordPress.
         *
         * @return void
         */
        public function wcpf_register_taxonomies()
        {
            $wcpf_get_taxonomy_array = get_option('wcpf_custom_taxonomy');

            if (is_array($wcpf_get_taxonomy_array)) {
                foreach ($wcpf_get_taxonomy_array as $key => $wcpf_get_taxonomy_vals) {
                    // Create the custom taxonomy
                    $wcpf_get_taxonomy_val = $wcpf_get_taxonomy_vals['taxonomy_name'];
                    $labels = array(
                        'name' => _x($wcpf_get_taxonomy_val, 'taxonomy general name'),
                        'singular_name' => _x($wcpf_get_taxonomy_val, 'taxonomy singular name'),
                        'search_items' => __('Search ' . $wcpf_get_taxonomy_val),
                        'all_items' => __('All ' . $wcpf_get_taxonomy_val),
                        'parent_item' => __('Parent ' . $wcpf_get_taxonomy_val),
                        'parent_item_colon' => __('Parent ' . $wcpf_get_taxonomy_val . ':'),
                        'edit_item' => __('Edit ' . $wcpf_get_taxonomy_val),
                        'update_item' => __('Update ' . $wcpf_get_taxonomy_val),
                        'add_new_item' => __('Add New ' . $wcpf_get_taxonomy_val),
                        'new_item_name' => __('New ' . $wcpf_get_taxonomy_val . ' Name'),
                        'menu_name' => __($wcpf_get_taxonomy_val),
                    );

                    $args = array(
                        'hierarchical' => true,
                        'labels' => $labels,
                        'show_ui' => true,
                        'show_admin_column' => true,
                        'query_var' => true,
                        'rewrite' => array('slug' => $wcpf_get_taxonomy_val),
                    );

                    $wcpf_get_taxonomy_val = str_replace(" ", "", $wcpf_get_taxonomy_val);
                    register_taxonomy($wcpf_get_taxonomy_val, 'product', $args);
                }
            }


        }





    }
}

new WCPFCF_Register_taxonomy();


