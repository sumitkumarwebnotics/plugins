<?php
if (!class_exists('WCPFCF_Ajax_hooks')) {
    class WCPFCF_Ajax_hooks
    {

        public function __construct()
        {
            add_action('wp_ajax_delete_custom_option', [$this, 'wcpf_delete_custom_option']);
            add_action('wp_ajax_wcpf_update_custom_field_option', [$this, 'wcpf_update_custom_field_option']);
            add_action('wp_ajax_wcpf_delete_taxonomy', [$this, 'wcpf_delete_taxonomy']);
            add_action('wp_ajax_wcpf_update_taxonomy_option', [$this, 'wcpf_update_taxonomy_option']);
            add_action('wp_ajax_wcpf_update_status_woo_cat_checkbox', [$this, 'wcpf_update_status_woo_cat_checkbox']);

            add_action('wp_ajax_wcpf_product_filter_by_cstm', [$this, 'wcpf_product_filter_by_custom_fields']);
            add_action('wp_ajax_nopriv_wcpf_product_filter_by_cstm', [$this, 'wcpf_product_filter_by_custom_fields']);
            add_action('admin_footer', [$this, 'wcpf_add_ajax_functions']);
        }



        // For delete custom fields

        /**
         * Delete a custom option from the plugin settings or database.
         *
         * This function processes the request to delete a specific custom option.
         * It checks for the necessary security nonce, verifies user permissions, 
         * and performs the deletion operation. It is typically used in admin 
         * interfaces or settings pages where users can manage custom options.
         *
         * @return void
         */
        public function wcpf_delete_custom_option()
        {
            $get_delete_value = sanitize_text_field($_POST['option_name']);
            // Get the existing custom fields array from wp_options

            $existing_custom_fieldss = get_option('wcpf_custom_fields');
            unset($existing_custom_fieldss[$get_delete_value]);
            update_option('wcpf_custom_fields', $existing_custom_fieldss);

            echo '<div class="delete"><p>' . __("Custom field deleted successfully!", "woo-custom-filter-by-webnotics") . '</p></div>';
        }

        /**
         * Update a custom field option in the plugin settings or database.
         *
         * This function processes the request to update a specific custom field option.
         * It checks for the necessary security nonce, verifies user permissions,
         * and performs the update operation. It is typically used in admin interfaces 
         * or settings pages where users can manage custom field options.
         *
         * @return void
         */
        public function wcpf_update_custom_field_option()
        {
            $get_option_name = sanitize_text_field($_POST['option_name']);
            $get_update_value = sanitize_text_field($_POST['value']);
            $existing_custom_fieldss = get_option('wcpf_custom_fields');
            $existing_custom_fieldss[$get_option_name]['field_status'] = $get_update_value;
            update_option('wcpf_custom_fields', $existing_custom_fieldss);
        }

        /**
         * Delete a custom taxonomy from the plugin settings or database.
         *
         * This function processes the request to delete a specific custom taxonomy.
         * It checks for the necessary security nonce, verifies user permissions, 
         * and performs the deletion operation. It is typically used in admin 
         * interfaces or settings pages where users can manage custom taxonomies.
         *
         * @return void
         */
        public function wcpf_delete_taxonomy()
        {
            $data_name = sanitize_text_field($_POST['data_name']);
            $wcpf_get_taxonomy_array = get_option('wcpf_custom_taxonomy');

            unset($wcpf_get_taxonomy_array[$data_name]);
            update_option('wcpf_custom_taxonomy', $wcpf_get_taxonomy_array);

            wp_die();
        }

        /**
         * Update a custom taxonomy option in the plugin settings or database.
         *
         * This function processes the request to update a specific custom taxonomy option.
         * It checks for the necessary security nonce, verifies user permissions, 
         * and performs the update operation. It is typically used in admin interfaces 
         * or settings pages where users can manage custom taxonomy options.
         *
         * @return void
         */
        public function wcpf_update_taxonomy_option()
        {
            $key_name = sanitize_text_field($_POST['key_name']);
            $taxonomy_status = sanitize_text_field($_POST['taxonomy_status']);
            $existing_custom_fieldss = get_option('wcpf_custom_taxonomy');

            $existing_custom_fieldss[$key_name]['taxonomy_status'] = $taxonomy_status;
            update_option('wcpf_custom_taxonomy', $existing_custom_fieldss);
        }

        /**
         * Update a checkbox woocommerce category option in the plugin settings or database.
         *
         * This function processes the request to update a woocommerce category option.
         * It checks for the necessary security nonce, verifies user permissions, 
         * and performs the update operation. It is typically used in admin interfaces 
         * or settings pages where users can manage woocommerce category options.
         *
         * @return void
         */
        public function wcpf_update_status_woo_cat_checkbox()
        {

            $woo_cat_checkbox = sanitize_text_field($_POST['woo_cat_checkbox']);

            update_option('enable_filter_woo_cat', $woo_cat_checkbox);
        }

        /*-----------------------------------------------------*/
        /*        Ajax for filter products on shop page        */
        /*-----------------------------------------------------*/

        /**
         * Filter products on the shop page based on custom fields.
         *
         * This function modifies the main WooCommerce query to filter products 
         * based on custom fields. It retrieves filter criteria from user input, 
         * applies these criteria to the product query, and adjusts the displayed 
         * products accordingly.
         * By using Ajax
         * @param WP_Query $query The WP_Query instance (passed by reference).
         * @return Array of products 
         */
        public function wcpf_product_filter_by_custom_fields()
        {
            $customfieldArray = isset($_POST['customfieldArray']) ? array_map('sanitize_text_field', (array) $_POST['customfieldArray']) : array();
            $taxonomyArray = isset($_POST['taxonomyArray']) ? array_map('sanitize_text_field', (array) $_POST['taxonomyArray']) : array();
            $checkboxValuescustom_field = isset($_POST['checkboxValuescustom_field']) ? array_map('sanitize_text_field', (array) $_POST['checkboxValuescustom_field']) : array();
            $search_keyword = isset($_POST['search_keyword']) ? sanitize_text_field($_POST['search_keyword']) : "";
            $tags = isset($_POST['tags']) ? sanitize_text_field($_POST['tags']) : "";
            $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
            $min_price = isset($_POST['min_price']) ? floatval($_POST['min_price']) : 0;
            $max_price = isset($_POST['max_price']) ? floatval($_POST['max_price']) : 0;

            check_ajax_referer('web_secure_webnotics', 'security');
            ob_start();

            if (!empty($customfieldArray) || !empty($taxonomyArray) || !empty($checkboxValuescustom_field)) {
                $arg = array();

                foreach ($customfieldArray as $key => $selected_values) {
                    $selected_values_name = $selected_values['name'];
                    $selected_values_value = $selected_values['value'];

                    if (!empty($selected_values_value) && $selected_values_value != "Select Option") {
                        $arg[] = array(
                            'key' => $selected_values_name,
                            'value' => $selected_values_value,
                            'compare' => '=',
                        );
                    }
                }

                if (is_array($checkboxValuescustom_field) && isset($checkboxValuescustom_field)) {

                    foreach ($checkboxValuescustom_field as $key => $value) {



                        if (is_array($value)) {
                            $meta_queriesCheckBox = array('relation' => 'OR');
                            foreach ($value as $key1 => $value1) {
                                $meta_queriesCheckBox[] = array(
                                    'key' => $key,
                                    'value' => 's:' . strlen($value1) . ':"' . $value1 . '";',
                                    'compare' => 'LIKE'
                                );

                            }

                            if (!empty($meta_queriesCheckBox)) {
                                $arg[] = array(
                                    'relation' => 'OR',
                                    $meta_queriesCheckBox
                                );
                            }



                        }


                    }

                }
                $taxonomy = array();
                if (!empty($taxonomyArray)) {
                    $taxnomyQueryArray = array('relation' => 'OR');
                    foreach ($taxonomyArray as $key => $selected_values) {
                        $selected_values_name = $selected_values['name'];
                        $selected_values_value = $selected_values['value'];
                        if (!empty($selected_values_value) && $selected_values_value != "Select Option") {
                            $taxnomyQueryArray[] = array(
                                'taxonomy' => $selected_values_name,
                                'field' => 'id',
                                'terms' => $selected_values_value,
                            );
                        }
                    }

                    if (!empty($taxnomyQueryArray)) {
                        $taxonomy[] = array(
                            'relation' => 'OR',
                            $taxnomyQueryArray
                        );
                    }


                }

                if (!empty($tags) && get_option('wpcf_filter_by_tag_option')) {

                    $taxonomy[] = array(
                        'taxonomy' => 'product_tag',
                        'field' => 'slug',
                        'terms' => $tags,
                        'operator' => 'IN', // Match any of the selected tags
                    );
                }

                $taxonomy['relation'] = 'AND';


                if (get_option('wpcf_search_by_price_option')) {
                    $arg[] = array(
                        'key' => '_price',
                        'value' => array($min_price, $max_price),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC'
                    );
                }

                if (!empty($rating) && get_option('wpcf_filter_by_rating_option')) {
                    $arg[] = array(
                        'key' => '_wc_average_rating',
                        'value' => $rating,
                        'compare' => '>=',
                        'type' => 'DECIMAL(2,1)',
                    );
                }

                /*--  search by sku, if not found sku product then move to search by keyword ---------*/
                if (!empty($search_keyword)) {
                    $check_sku_product = $this->check_sku_product($search_keyword);
                }
                $search_query = '';
                if (!empty($search_keyword) && $check_sku_product > 0) {
                    $arg[] = array(
                        'key' => '_sku',
                        'value' => $search_keyword,
                        'compare' => 'LIKE'
                    );
                } else {
                    $search_query = $search_keyword;
                }
                /*-- end code for  search by sku, if not found sku product then move to search by keyword --*/



                if (!empty($selected_values)) {

                    $paged = ($_REQUEST['page_number']) ? $_REQUEST['page_number'] : 1;
                    $orderby = ($_REQUEST['orderby']) ? $_REQUEST['orderby'] : "title";
                    $per_page = 12;
                    $current = $paged;
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => $per_page,
                        's' => $search_query,
                        'orderby' => $orderby,
                        'order' => 'ASC',
                        'paged' => $paged,
                        'meta_query' => array(array('relation' => 'AND'), $arg),
                        'tax_query' => $taxonomy
                    );

                    $products_query = new WP_Query($args);

                    $total = $products_query->found_posts;
                    echo '<p style="padding:15px 0;">';
                    if (1 === intval($total)) {
                        _e('Showing the single result', 'woocommerce');
                    } elseif ($total <= $per_page || -1 === $per_page) {
                        /* translators: %d: total results */
                        printf(_n('Showing all %d result', 'Showing all %d results', $total, 'woocommerce'), $total);
                    } else {
                        $first = ($per_page * $current) - $per_page + 1;
                        $last = min($total, $per_page * $current);
                        /* translators: 1: first result 2: last result 3: total results */
                        printf(_nx('Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'woocommerce'), $first, $last, $total);
                    }
                    echo '</p>';


                    $products = '';
                    if ($products_query->have_posts()) {
                        woocommerce_product_loop_start();
                        while ($products_query->have_posts()):
                            $products_query->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        woocommerce_product_loop_end();
                        echo '<nav class="woocommerce-pagination">';
                        $prev_arrow = is_rtl() ? '<span class="arrow-right"></span><span class="direction-text">Next</span>' : '<span class="arrow-left"></span><span class="direction-text">Prev</span>';
                        $next_arrow = is_rtl() ? '<span class="arrow-left"></span><span class="direction-text">Prev</span>' : '<span class="arrow-right"></span><span class="direction-text">Next</span>';
                        $total = $products_query->max_num_pages;
                        $big = 999999999; // need an unlikely integer



                        if ($total > 1) {
                            if (!$current_page = get_query_var('paged'))
                                $current_page = $paged;
                            if (get_option('permalink_structure')) {
                                $format = 'page/%#%/';
                            } else {
                                $format = '?paged=%#%';
                            }
                            global $wp_rewrite, $wp_query;
                            $base = trailingslashit($_SERVER['HTTP_REFERER']) . "{$wp_rewrite->pagination_base}/%#%/";
                            echo paginate_links(array(
                                'base' => $base,
                                'format' => $format,
                                'current' => max(1, $paged),
                                'total' => $total,
                                'mid_size' => 3,
                                'type' => 'list',

                            ));

                        }
                        wp_reset_postdata();
                        echo '</nav>';
                    } else {
                        $products = '<div class="product_not_found">No products found</div>';
                    }
                    echo $products;
                }
                $result = ob_get_clean();
                $response = array();
                $response['result'] = $result;
                wp_send_json($response);
                wp_die();
            }
        }

        /**
         * Check if a product with the given SKU exists
         * 
         * @param string $keyword The SKU or keyword to check
         * @return int The number of products with the matching SKU
         */
        public function check_sku_product($keyword)
        {
            $args = array(
                'post_type' => 'product',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => '_sku',
                        'value' => $keyword,
                        'compare' => 'LIKE'
                    )
                ),
                'posts_per_page' => 1,
            );
            $sku_query = new WP_Query($args);
            $post_count = $sku_query->found_posts;
            wp_reset_postdata(); // Reset query data
            return $post_count;

        }

        /**
         * Enqueue JavaScript for handling AJAX functions in the admin panel.
         *
         * This method enqueues JavaScript code that is used for handling AJAX requests
         * in the WordPress admin area. The script is added to the footer to ensure that
         * all necessary elements are loaded before the script runs. This script is used
         * for performing various AJAX operations related to the plugin or custom functionality.
         *
         * @return void
         */
        public function wcpf_add_ajax_functions()
        {
            // Add JavaScript to the footer for the admin panel
            ?>
            <script>
                jQuery(document).ready(function () {
                    jQuery("a.custom-options-delete-link").on("click", function (e) {
                        e.preventDefault();
                        if (confirm('Are you sure want to delete this item?')) {
                            var optionName = jQuery(this).attr("data-index");
                            var thisVar = jQuery(this);
                            thisVar.text("Processing");
                            jQuery.ajax({
                                type: "POST",
                                url: ajax_object.ajax_url,
                                data: { action: "delete_custom_option", option_name: optionName, security: ajax_object.ajax_nonce },
                                success: function (response) {
                                    console.log(response);
                                    thisVar.text("Deleted successfully");
                                    setTimeout(function () {
                                        thisVar.closest("tr").remove();
                                        location.reload();
                                    }, 3000);

                                }
                            });
                        } else {
                            return false;
                        }


                    });
                });
            </script>
            <?php

            // Add admin footer js script
            $plugin_url = WCPFCF_PLUGIN_DIR_URL;
            wp_enqueue_script('wpcf', $plugin_url . 'assets/js/wpcf.js', array('jquery'));
            wp_localize_script(
                'zip_js',
                'myAjax',
                array('ajaxurl' => admin_url('admin-ajax.php'))
            );

        }

    }
}

new WCPFCF_Ajax_hooks();


