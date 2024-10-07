<?php
if (!class_exists('WCPFCF_Product_edit_page')) {
    class WCPFCF_Product_edit_page
    {

        public function __construct()
        {
            add_filter('woocommerce_product_data_tabs', [$this, 'custom_filter_option_product_settings_tabs']);
            add_action('woocommerce_product_data_panels', [$this, 'custom_filter_option_data_panels']);
            add_action('woocommerce_process_product_meta', [$this, 'wcpf_save_custom_fields_data']);
        }

        /*-------------------------------------------------------------------*/
        /*                          For Edit product page code                     */
        /*-------------------------------------------------------------------*/

        /**
         * Add a custom tab to the WooCommerce product settings tabs.
         *
         * This function adds a new tab to the WooCommerce product settings page. 
         * The new tab allows users to access custom filter options specific to this plugin.
         *
         * @param array $tabs An array of existing WooCommerce product settings tabs.
         * @return array $tabs The modified array of WooCommerce product settings tabs, including the custom tab.
         */
        public function custom_filter_option_product_settings_tabs($tabs)
        {

            //unset( $tabs[ 'inventory' ] );

            $tabs['custom_filter_option'] = array(
                'label' => __('Custom Filter Option','woo-custom-filter-by-webnotics'),
                'target' => 'Custom_filter_option_data',
                'class' => '',
                'priority' => 21,
            );
            return $tabs;

        }

        /**
         * Display custom filter option data panels in the WooCommerce product settings.
         *
         * This function adds custom fields to the WooCommerce product settings based on the configuration
         * stored in the plugin options. The fields include dropdowns, radio buttons, text inputs, and checkboxes.
         */
        public function custom_filter_option_data_panels()
        {

            echo '<div id="Custom_filter_option_data" class="panel woocommerce_options_panel hidden">';
            global $post;
            $custom_field_type_data = get_option('wcpf_custom_fields');

            if (isset($custom_field_type_data) && is_array($custom_field_type_data)) {
                foreach ($custom_field_type_data as $key => $value) {

                    if (isset($value['field_name']) && !empty($value['field_name']) && $value['field_type'] == 'dropdown' && $value['field_status'] == 0) {
                        $optionVal = $value['field_textarea_value'];
                        $explode = explode(",", $optionVal);
                        $newArray = array();
                        foreach ($explode as $key1 => $value1) {
                            $newArray[$value1] = $value1;
                        }

                        $field_name = str_replace(" ", "_", $value['field_name']);
                        woocommerce_wp_select(
                            array(
                                'id' => '_' . $field_name,
                                'label' => $value['field_name'] . ":<br>",
                                'desc_tip' => 'true',
                                'description' => __('Select an option from the dropdown.', 'woocommerce'),
                                'options' => $newArray,

                            )
                        );

                    } elseif (isset($value['field_name']) && !empty($value['field_name']) && $value['field_type'] == 'radio' && $value['field_status'] == 0) {


                        $optionVal = $value['field_textarea_value'];
                        $explode = explode(",", $optionVal);
                        $newArray = array();
                        foreach ($explode as $key1 => $value1) {
                            $newArray[$value1] = $value1;
                        }

                        $field_name = str_replace(" ", "_", $value['field_name']);

                        woocommerce_wp_radio(
                            array(
                                'id' => '_' . $field_name,

                                'label' => __($value['field_name'] . ":<br>"),
                                'description' => '',
                                'options' => $newArray,
                                'value' => get_post_meta($post->ID, "_$field_name", true),
                            )
                        );

                    } elseif (isset($value['field_name']) && !empty($value['field_name']) && $value['field_type'] == 'input' && $value['field_status'] == 0) {

                        $field_name = str_replace(" ", "_", $value['field_name']);

                        woocommerce_wp_text_input(
                            array(
                                'id' => '_' . $field_name,
                                'label' => $value['field_name'] . ":<br>",
                                'desc_tip' => 'true',
                                'description' => $value['field_name'],
                                'value' => get_post_meta($post->ID, "_$field_name", true),
                            )
                        );
                    } elseif (isset($value['field_name']) && !empty($value['field_name']) && $value['field_type'] == 'checkbox' && $value['field_status'] == 0) {

                        $optionVal = $value['field_textarea_value'];
                        $options = array_map('trim', explode(",", $optionVal)); // Trim spaces around values

                        $field_name = str_replace(" ", "_", $value['field_name']);

                        // Get saved values from the database
                        $saved_values = get_post_meta($post->ID, '_' . $field_name, true);
                        $saved_values = is_array($saved_values) ? $saved_values : array(); // Ensure it's an array

                        echo '<div class="admin-checkboxes">';
                        echo '<span class="label">' . $value['field_name'] . ': </span>';
                        $checkbox_field = '_' . $field_name;
                        echo '<span class="list-checkboxes">';
                        foreach ($options as $checkbox) {
                            $checkbox = trim($checkbox); // Trim spaces around values
                            $checked = in_array($checkbox, $saved_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="' . $checkbox_field . '[]" value="' . esc_attr($checkbox) . '" ' . $checked . '>' . esc_html($checkbox) . '</label>';
                        }
                        echo '</span>';
                        echo '</div>';
                    }
                }

            }

            echo '</div>';



        }


        /**
         * Save custom fields data when a WooCommerce product is saved.
         *
         * This function processes and saves the custom fields added to the WooCommerce product edit page.
         * It checks for each custom field, sanitizes the input, and stores the data in the WordPress database.
         *
         * @param int $product_id The ID of the product being saved.
         */

        public function wcpf_save_custom_fields_data($product_id)
        {
            $custom_field_type_data = get_option('wcpf_custom_fields');

            foreach ($custom_field_type_data as $key => $value) {

                if (isset($value['field_name']) && !empty($value['field_name'])) {
                    $field_name = str_replace(" ", "_", $value['field_name']);
                    $keyName = '_' . $field_name;

                    if ($value['field_type'] == 'checkbox') {
                        $checkbox_values = isset($_POST[$keyName]) ? array_map('sanitize_text_field', $_POST[$keyName]) : array();
                        update_post_meta($product_id, $keyName, $checkbox_values);

                    } else {
                        update_post_meta($product_id, $keyName, sanitize_text_field($_POST[$keyName]));
                    }

                    $custom_checkbox = isset($_POST['custom_field']) ? 'yes' : 'no';
                    update_post_meta($product_id, 'custom_field', $custom_checkbox);
                }
            }
        }





    }
}

/**
 * Instantiate the WCPFCF_Product_edit_page class.
 *
 * This line creates a new instance of the WCPFCF_Product_edit_page class. 
 * The class is responsible for managing and displaying custom fields or settings 
 * related to WooCommerce product editing. It is typically used to integrate custom 
 * functionality or additional options into the WooCommerce product edit page in the 
 * WordPress admin dashboard.
 *
 * By creating an instance of this class, its constructor is executed, which may 
 * register hooks, initialize settings, or perform other setup tasks necessary 
 * for its functionality.
 */

new WCPFCF_Product_edit_page();


