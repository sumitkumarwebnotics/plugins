<?php
if (!class_exists('WCPFCF_shortcodes_shop_page')) {
    class WCPFCF_shortcodes_shop_page
    {

        public function __construct()
        {
            add_shortcode('WCPF_shop_page_let_sidebar', [$this, 'wcpf_shop_page_sidebar_function']);
            add_filter('template_include', [$this, 'wcpf_custom_shop_page_template'], 999999);
            add_action('wcpf_get_all_custom_taxonomies', [$this, 'wcpf_get_all_custom_taxonomies_function']);
        }

        /**
         * Generate and return the HTML for a dynamic sidebar.
         *
         * This function creates a sidebar with dynamic content, retrieving content from a wcpf_shop_page_sidebar_function Function.
         *
         * @since 1.0.0
         * @return string The HTML markup for the sidebar with dynamic content.
         */
        public function wcpf_shop_page_sidebar_function()
        {
            ob_start();
            $headingStyle = "";
            $price_range_color = "";
            $options = get_option('wpcf_customize_style_options');


            if (isset($options['heading_font_family'])) {
                $headingStyle .= 'font-family: ' . esc_attr($options['heading_font_family']) . ' !important; ';
            }

            if (isset($options['heading_font_size'])) {
                $headingStyle .= 'font-size: ' . esc_attr($options['heading_font_size']) . 'px !important; ';
            }

            if (isset($options['heading_text_color'])) {
                $headingStyle .= 'color: ' . esc_attr($options['heading_text_color']) . '!important; ';
            }
            if (isset($options['price_range_color'])) {
                $price_range_color .= 'background: ' . esc_attr($options['price_range_color']) . '!important; ';
            }
            if (!empty($price_range_color)) {

                echo '<style>div#price-range-slider .noUi-connect,div#price-range-slider.noUi-horizontal .noUi-tooltip,div#price-range-slider.noUi-horizontal .noUi-tooltip{ ' . $price_range_color . ' }</style>';
            }
            if (!empty($headingStyle)) {

                echo '<style>.wcpf-filter-heading,.taxonomy_names{ ' . $headingStyle . ' }</style>';
            }
            ?>
            <div class="wcpf_main_section_filter">
                <span class="close">Close</span>
                <?php if (get_option('wpcf_search_by_keyword_option')) { ?>
                    <div class="wcpf__search">
                        <h5 class="wcpf-filter-heading"><?= __("Filter by Search keyword", "woo-custom-filter-by-webnotics") ?></h5>
                        <input type="text" name="search_keyword" class="form-control wcpf_input_filter"
                            placeholder="<?= __("Search by keyword or SKU", "woo-custom-filter-by-webnotics") ?>">
                    </div>
                <?php } ?>

                <?php if (get_option('wpcf_search_by_price_option')) { ?>
                    <div class="wcpf__price">
                        <h5 class="wcpf-filter-heading"><?= __("Filter by Price", "woo-custom-filter-by-webnotics") ?></h5>
                        <div id="price-range-slider"></div>
                        <input type="hidden" id="min_price" name="min_price" value="">
                        <input type="hidden" id="max_price" name="max_price" value="">
                        <span id="price-range-text"></span>
                    </div>
                    <script>

                        jQuery(document).ready(function ($) {
                            var slider = document.getElementById('price-range-slider');
                            var currency_symbol = "<?php echo html_entity_decode(get_woocommerce_currency_symbol()); ?>";

                            noUiSlider.create(slider, {
                                start: [0, <?= $this->wcpf_get_max_product_price() ?>],
                                connect: true,
                                range: {
                                    'min': 0,
                                    'max': <?= $this->wcpf_get_max_product_price() ?>
                                },
                                tooltips: [true, true],
                                format: {
                                    to: function (value) {
                                        return Math.round(value);
                                    },
                                    from: function (value) {
                                        return Number(value);
                                    }
                                }
                            });


                            slider.noUiSlider.on('update', function (values, handle) {
                                $('#min_price').val(values[0]);
                                $('#max_price').val(values[1]);
                                $('#price-range-text').text('<?= __("Price:", "woo-custom-filter-by-webnotics") ?> ' + currency_symbol + values[0] + ' - ' + currency_symbol + values[1]);
                            });

                            // Preserve the values on page reload or submit
                            <?php if (isset($_GET['min_price'])): ?>
                                slider.noUiSlider.set([<?php echo esc_js($_GET['min_price']); ?>, <?php echo esc_js($_GET['max_price']); ?>]);
                            <?php endif; ?>
                        });

                    </script>
                <?php } ?>

                <?php if (get_option('wpcf_filter_by_rating_option')) { ?>
                    <div class="wcpf__rating">
                        <h5 class="wcpf-filter-heading"><?= __("Filter by rating", "woo-custom-filter-by-webnotics") ?></h5>
                        <div>
                            <input type="radio" id="5-stars" name="rating" value="5" <?php checked(isset($_GET['rating']) && absint($_GET['rating']) == 5); ?>>
                            <label for="5-stars">
                                <div class="rating-5">
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                </div> <?= __("5 only", "woo-custom-filter-by-webnotics") ?>
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="4-stars" name="rating" value="4" <?php checked(isset($_GET['rating']) && absint($_GET['rating']) == 4); ?>>
                            <label for="4-stars">
                                <div class="rating-4">
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                    <span class="star">★</span>
                                </div> <?= __("and Up", "woo-custom-filter-by-webnotics") ?>
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="3-stars" name="rating" value="3" <?php checked(isset($_GET['rating']) && absint($_GET['rating']) == 3); ?>>
                            <label for="3-stars">
                                <div class="rating-3">
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                </div> <?= __("and Up", "woo-custom-filter-by-webnotics") ?>
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="2-stars" name="rating" value="2" <?php checked(isset($_GET['rating']) && absint($_GET['rating']) == 2); ?>>
                            <label for="2-stars">
                                <div class="rating-2">
                                    <span class="star-active">★</span>
                                    <span class="star-active">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                </div> <?= __("and Up", "woo-custom-filter-by-webnotics") ?>
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="1-star" name="rating" value="1" <?php checked(isset($_GET['rating']) && absint($_GET['rating']) == 1); ?>>
                            <label for="1-star">
                                <div class="rating-4">
                                    <span class="star-active">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                </div> <?= __("and Up", "woo-custom-filter-by-webnotics") ?>
                            </label>
                        </div>

                    </div>
                <?php } ?>

                <?php if (get_option('wpcf_filter_by_tag_option')) { ?>
                    <div class="wcpf__tags">
                        <h5 class="wcpf-filter-heading"><?= __("Filter by Tags", "woo-custom-filter-by-webnotics") ?></h5>
                        <select data-placeholder="<?= __("Choose tags ...", "woo-custom-filter-by-webnotics") ?>" name="tags[]" multiple
                            class="chosen-select">
                            <?php
                            $tags = get_terms(array(
                                'taxonomy' => 'product_tag',
                                'hide_empty' => true,
                            ));

                            if (!empty($tags) && !is_wp_error($tags)) {
                                foreach ($tags as $tag) {
                                    // Sanitize the incoming $_GET['filter_tags'] data
                                    $filter_tags = isset($_GET['filter_tags']) ? array_map('sanitize_text_field', $_GET['filter_tags']) : [];

                                    // Check if the tag is selected and properly sanitize the output
                                    $selected = in_array($tag->slug, $filter_tags) ? 'selected="selected"' : '';

                                    // Safely echo the option element with sanitized attributes and text
                                    echo '<option value="' . esc_attr($tag->slug) . '" ' . $selected . '>' . esc_html($tag->name) . '</option>';
                                }

                            }
                            ?>
                            <script>
                                jQuery(document).ready(function () {
                                    jQuery(".chosen-select").chosen();
                                });

                            </script>
                        </select>

                    </div>

                <?php } ?>



                <?php
                $all_custom_fields = get_option('wcpf_custom_fields');

                if (!empty($all_custom_fields)) {
                    ?>

                    <input type="hidden" name="orderby"
                        value="<?= (isset($_REQUEST['orderby']) ? sanitize_text_field($_REQUEST['orderby']) : 'title'); ?>">
                    <input type="hidden" class="page__number" name="page_number" value="1">
                    <form class="custom_field_form" method="post" action="">
                        <?php
                        foreach ($all_custom_fields as $key => $all_custom_fields_data) {
                            $field_name = $all_custom_fields_data['field_name'];
                            $field_type = $all_custom_fields_data['field_type'];
                            $field_status = $all_custom_fields_data['field_status'];
                            $field_textarea_value = $all_custom_fields_data['field_textarea_value'];
                            $field_textarea_values = explode(',', $field_textarea_value);

                            if ($field_status == 0) {
                                echo $this->wcpf_dropdown($field_type, $field_name, $field_textarea_values);
                            }
                        }
                        ?>
                    </form>
                    <form method="post" class="taxonomy_form">
                        <?php
                        do_action('wcpf_get_all_custom_taxonomies');
                        ?>
                    </form>
                    <div class="filter__container_btn">
                        <?php
                        $buttonStyle = $buttonTextStyle = "";
                        $options = get_option('wpcf_customize_style_options');


                        if (isset($options['button_background_color'])) {
                            $buttonStyle .= 'background-color: ' . esc_attr($options['button_background_color']) . '; ';
                        }

                        if (isset($options['button_font_family'])) {
                            $buttonStyle .= 'font-family: ' . esc_attr($options['button_font_family']) . '; ';
                        }

                        if (isset($options['button_font_size'])) {
                            $buttonStyle .= 'font-size: ' . esc_attr($options['button_font_size']) . 'px; ';
                        }

                        if (isset($options['button_text_color'])) {
                            $buttonStyle .= 'color: ' . esc_attr($options['button_text_color']) . '; ';
                        }

                        if (!empty($buttonStyle)) {
                            $buttonStyle = 'style="' . $buttonStyle . '"';
                        }
                        if (isset($options['button_text_color'])) {
                            $buttonTextStyle = 'style="color: ' . esc_attr($options['button_text_color']) . ';"';
                        }
                        ?>
                        <button class="btn btn-success filter_id" <?= $buttonStyle ?>>
                            <div class="filter_loader" style="display:none;"></div><span class="fltr_btn" <?= $buttonTextStyle ?>><?= __("Filter", "woo-custom-filter-by-webnotics") ?></span>
                        </button>
                        <button class="wcpf_clear_all_field" <?= $buttonStyle ?>><?= __("Clear filter", "woo-custom-filter-by-webnotics") ?></button>
                    </div>

                    <script>
                        jQuery(document).on("click", ".wcpf_clear_all_field", function () {
                            jQuery('.wcpf_main_section_filter input[type="checkbox"]').prop('checked', false);
                            jQuery('.wcpf_main_section_filter input[type="radio"]').prop('checked', false);
                            jQuery('.wcpf_main_section_filter select').prop('selectedIndex', 0);
                            jQuery('.wcpf_main_section_filter input[type=text]').val("");
                            jQuery('.chosen-select option').prop('selected', false).trigger('chosen:updated');
                            jQuery('#price-range-slider')[0].noUiSlider.set([0, <?= $this->wcpf_get_max_product_price() ?>]);
                            jQuery(".filter_id").trigger("click");
                        });
                    </script>
                    <?php
                }

                echo '</div>';

                return ob_get_clean();
        }

        /**
         * Generate and return the HTML for a Custom taxonomy.
         *
         * This function generate taxonomy HTML list from wcpf_custom_taxonomy options (prefix_options).
         *
         * @since 1.0.0
         * @return string The HTML markup for the taxonomy list.
         */
        public function wcpf_get_all_custom_taxonomies_function()
        {
            $wpcf_get_all_taxonomies_data = get_option('wcpf_custom_taxonomy');
            $get_product_counts = $this->wcpf_all_get_product_counts_by_taxonomies();
            if (isset($get_product_counts) && $get_product_counts > 0) {


                if (isset($wpcf_get_all_taxonomies_data) && is_array($wpcf_get_all_taxonomies_data)) {
                    echo '<div class="wcpf-main-taxonomies-filters">';
                    echo '<h5 class="wcpf-filter-heading">' . __("Filter By Taxonomies", "woo-custom-filter-by-webnotics") . '</h5>';


                    foreach ($wpcf_get_all_taxonomies_data as $key => $wpcf_taxonomy_data) {
                        $field_status = $wpcf_taxonomy_data['taxonomy_status'];
                        if ($field_status == 0) {
                            $taxonomy_name = $wpcf_taxonomy_data['taxonomy_name'];
                            $taxonomy_name = str_replace(" ", "", $taxonomy_name);
                            if ($this->wcpf_get_product_count_by_taxonomy($taxonomy_name) > 0) {
                                echo '<h5 class="taxonomy_names">' . esc_html(ucfirst($wpcf_taxonomy_data['taxonomy_name'])) . " (" . $this->wcpf_get_product_count_by_taxonomy($taxonomy_name) . ') </h5>';
                                $taxonomy = $taxonomy_name;
                                $this->wcpf_display_terms_with_hierarchy($taxonomy);

                            }
                        }
                    }

                    echo '</div>';
                }
            }

            $woo_cat = get_option('enable_filter_woo_cat');
            if ($woo_cat == 1) {
                if (is_product_category()) {
                    // This is a product category page
                    $term = get_queried_object(); // Get the current term object
                    $term_id = $term->term_id; // Get the term ID

                    if (isset($term_id)) {
                        $this->wcpf_display_terms_with_hierarchy_product_cat('product_cat', $term_id);
                    }

                } else {


                    echo '<h5 class="taxonomy_names">' . __("Woocommerce Category", "woo-custom-filter-by-webnotics") . '</h5>';
                    echo '<div class="wcpf-main-taxonomies-filters">';
                    $this->wcpf_display_terms_with_hierarchy('product_cat');
                    echo '</div>';

                }

            }
        }


        public function wcpf_get_related_term_by_id_pro_cat()
        {

            $current_term = get_queried_object();

            if ($current_term && !is_wp_error($current_term)) {

                $current_term_id = $current_term->term_id;

                $custom_taxonomies = get_object_taxonomies('product', 'names');


                $args = [
                    'post_type' => 'product',
                    'posts_per_page' => -1,
                    'tax_query' => [
                        [
                            'taxonomy' => $current_term->taxonomy,
                            'field' => 'term_id',
                            'terms' => $current_term_id,
                        ],
                    ],
                ];

                $products = new WP_Query($args);


                $product_taxonomy_terms = [];

                if ($products->have_posts()) {

                    while ($products->have_posts()) {
                        $products->the_post();

                        $product_id = get_the_ID();

                        foreach ($custom_taxonomies as $taxonomy) {

                            $product_terms = wp_get_post_terms($product_id, $taxonomy);

                            foreach ($product_terms as $product_term) {
                                $product_taxonomy_terms[] = $product_term->term_id;
                            }
                        }
                    }

                    wp_reset_postdata();

                    return $product_taxonomy_terms;
                } else {
                    return false;
                }
            } else {
                return false;
            }



        }

        /**
         * Get the maximum price of a product.
         *
         * This function retrieves and returns the maximum price of a WooCommerce product.
         * It can be useful in contexts where variable pricing exists, such as variable products
         * with multiple price ranges.
         *
         * @since 1.0.0
         * @return float $max_price The maximum price of the product.
         */
        public function wcpf_get_max_product_price()
        {
            global $wpdb;

            // Prepare the query to get the maximum price from the product meta table
            $query = $wpdb->prepare(
                "
                                    SELECT MAX(CAST(meta_value AS DECIMAL(10,2))) 
                                    FROM {$wpdb->postmeta} 
                                    WHERE meta_key = %s
                                    ",
                '_price'
            );

            // Execute the query and get the result
            $max_price = $wpdb->get_var($query);

            return $max_price;
        }

        /**
         * Generate HTML for various form elements.
         *
         * This function generates and returns HTML for different types of form elements: radio button, text input, checkbox, and dropdown.
         * The generated HTML can be used in forms where these inputs are required.
         *
         * @since 1.0.0
         * @return string $html The generated HTML for the form elements.
         */
        public function wcpf_dropdown($attr, $field_name, $field_textarea_values)
        {
            if ($attr == "dropdown") {
                $field_slug = str_replace(' ', '_', $field_name);
                ?>
                    <div class="wcpf_select_dropdown">
                        <div class="select_heading">
                            <h5 class="wcpf-filter-heading"><?= __("Filter By", "woo-custom-filter-by-webnotics") ?>
                                <?= esc_html($field_name); ?>
                            </h5>
                        </div>
                        <div class="dropdown_card">
                            <select name="_<?= esc_attr($field_slug); ?>" class="wcpf_select_size">
                                <option><?= __("Select Option", "woo-custom-filter-by-webnotics") ?></option>
                                <?php

                                foreach ($field_textarea_values as $field_textarea_values_data) {
                                    ?>
                                    <option value="<?php echo esc_attr($field_textarea_values_data); ?>">
                                        <?php echo esc_html($field_textarea_values_data); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
            } elseif ($attr == "radio") {
                ?>
                    <div class="wcpf_select_radio">
                        <div class="select_heading">
                            <h5 class="wcpf-filter-heading"><?= __("Filter By", "woo-custom-filter-by-webnotics") ?>
                                <?= esc_html($field_name); ?>
                            </h5>
                        </div>
                        <div class="wcpf_select_radio_options">
                            <?php
                            foreach ($field_textarea_values as $field_textarea_values_data) {
                                $field_slug = str_replace(' ', '_', $field_name);
                                ?>
                                <input type="radio" name="_<?= esc_attr($field_slug); ?>" class="wcpf_select_radio_btn"
                                    value="<?php echo esc_attr($field_textarea_values_data); ?>"
                                    id="<?php echo esc_attr($field_textarea_values_data) . $field_slug; ?>">
                                <label
                                    for="<?php echo esc_attr($field_textarea_values_data) . $field_slug; ?>"><?php echo esc_html($field_textarea_values_data); ?></label><br>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
            } elseif ($attr == "input") {
                ?>
                    <div class="wcpf_select_input">
                        <div class="select_heading">
                            <h5 class="wcpf-filter-heading"><?= __("Filter By", "woo-custom-filter-by-webnotics") ?>
                                <?= esc_html($field_name); ?>
                            </h5>
                        </div>
                        <?php
                        foreach ($field_textarea_values as $field_textarea_values_data) {
                            $field_slug = str_replace(' ', '_', $field_name);
                            ?>
                            <div class="form-group">
                                <input type="text" name="_<?= esc_attr($field_slug); ?>" class="form-control wcpf_input_filter"
                                    placeholder="<?= __("Enter Value...", "woo-custom-filter-by-webnotics") ?>">
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
            } elseif ($attr == "checkbox") {
                $field_slug = str_replace(" ", "_", $field_name);
                ?>
                    <div class="wcpf_select_checkboxes">
                        <div class="select_heading">
                            <h5 class="wcpf-filter-heading"><?= __("Filter By", "woo-custom-filter-by-webnotics") ?>
                                <?= esc_html($field_name); ?>
                            </h5>
                        </div>
                        <div class="wcpf_select_checkbox_options">
                            <?php
                            foreach ($field_textarea_values as $field_textarea_values_data) {
                                ?>
                                <input type="checkbox" name="_<?= esc_attr($field_slug); ?>" class="wcpf_select_checkbox_btn"
                                    value="<?php echo esc_attr(trim($field_textarea_values_data)); ?>"
                                    id="<?php echo esc_attr($field_textarea_values_data) . $field_slug; ?>">
                                <label
                                    for="<?php echo esc_attr($field_textarea_values_data) . $field_slug; ?>"><?php echo esc_html($field_textarea_values_data); ?></label><br>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
            }
        }

        /**
         * Display terms of a specified taxonomy in a hierarchical format.
         *
         * This function retrieves and displays the terms of a given taxonomy, organized hierarchically.
         * It generates an HTML list where parent terms are listed with their child terms nested beneath them.
         *
         * @since 1.0.0
         * @param string $taxonomy The taxonomy slug to retrieve terms from.
         * @return string $html The HTML markup for the hierarchical list of terms.
         */
        public function wcpf_display_terms_with_hierarchy($taxonomy)
        {

            $top_level_terms = get_terms([
                'taxonomy' => $taxonomy,
                'parent' => 0,
            ]);

            if (!empty($top_level_terms)) {
                ?>
                    <ul class="wcpf_parent-cat prnt_display_<?php echo esc_attr($taxonomy); ?>"><?php
                       foreach ($top_level_terms as $top_level_term) {
                           $this->wcpf_display_subcategories_recursive($top_level_term, $taxonomy);
                       } ?>
                    </ul><?php
            }

        }

        public function wcpf_display_terms_with_hierarchy_product_cat($taxonomy, $term_id)
        {

            $parent_term = get_term($term_id, $taxonomy);

            if (!is_wp_error($parent_term) && $parent_term) {

                $top_level_terms = [$parent_term];

                if (!empty($top_level_terms)) {
                    ?>
                        <ul class="wcpf_parent-cat prnt_display_<?php echo esc_attr($taxonomy); ?>"><?php
                           foreach ($top_level_terms as $top_level_term) {
                               $this->wcpf_display_subcategories_recursive_product_cat($top_level_term, $taxonomy);
                           } ?>
                        </ul><?php
                }

            }

        }

        /**
         * Display subcategories of a specified taxonomy starting from a parent term.
         *
         * This function generates an HTML list of subcategories (or terms) in a specified taxonomy,
         * starting from the given parent term and displaying all levels of subcategories recursively.
         *
         * @since 1.0.0
         * @param int    $parent_term The ID of the parent term to start displaying subcategories from.
         * @param string $taxonomy    The taxonomy slug to retrieve terms from.
         * @return string $html The HTML markup for the hierarchical list of subcategories.
         */
        public function wcpf_display_subcategories_recursive($parent_term, $taxonomy)
        {
            $child_terms = get_terms([
                'taxonomy' => $taxonomy,
                'parent' => $parent_term->term_id,
            ]);

            if (is_product_category()) {
                $arrayRelatedCat = $this->wcpf_get_related_term_by_id_pro_cat();

                $checkedStatus = (in_array($parent_term->term_id, $arrayRelatedCat)) ? "" : "disabled";
                if (!empty($child_terms)) {
                    $pt_id = $parent_term->term_id;
                    $child_terms_link = get_term_link($parent_term->term_id);
                    $taxonomyslug = $pt_id;
                    $this->toggle_taxonomies_function($taxonomyslug);



                    ?>
                        <li class="wcpf-parent-cat-li" style="opacity:<?= ($checkedStatus == "disabled") ? '0.4' : '1'; ?>">
                            <input type="checkbox" id="<?php echo esc_url($child_terms_link) ?>" class="child_cat_check"
                                name="child_cat_check_<?php echo esc_attr($parent_term->slug); ?>"
                                data-taxonomy_name="<?php echo esc_attr($taxonomy); ?>"
                                value="<?php echo esc_attr($parent_term->term_id); ?>" <?= $checkedStatus ?>>
                            <span class="prt_check_<?php echo esc_attr($taxonomyslug); ?>">
                                <label
                                    for="<?php echo esc_url($child_terms_link) ?>"><?php echo esc_html($parent_term->name . '(' . $parent_term->count . ')'); ?></label><span
                                    class="arrow">&#9660;</span>
                            </span>
                            <ul class="wcpf_child-cat wcpf_child_cats_<?php echo esc_attr($taxonomyslug); ?>">
                                <?php
                                foreach ($child_terms as $child_term) {
                                    $this->wcpf_display_subcategories_recursive($child_term, $taxonomy);
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                } else {
                    $child_terms_link = get_term_link($parent_term->term_id);
                    ?>
                        <li class="child-cat-li" style="opacity:<?= ($checkedStatus == "disabled") ? '0.4' : '1'; ?>">
                            <input type="checkbox" id="<?php echo esc_url($child_terms_link); ?>" class="child_cat_check"
                                name="child_cat_check_<?php echo esc_attr($parent_term->slug); ?>"
                                data-taxonomy_name="<?php echo esc_attr($taxonomy); ?>"
                                value="<?php echo esc_attr($parent_term->term_id); ?>" <?= $checkedStatus ?>>
                            <label
                                for="<?php echo esc_url($child_terms_link); ?>"><?php echo esc_html($parent_term->name . '(' . $parent_term->count . ')'); ?>
                            </label>
                        </li>
                        <?php
                }


            } else {






                if (!empty($child_terms)) {
                    $pt_id = $parent_term->term_id;
                    $child_terms_link = get_term_link($parent_term->term_id);
                    $taxonomyslug = $pt_id;
                    $this->toggle_taxonomies_function($taxonomyslug);
                    ?>
                        <li class="wcpf-parent-cat-li">
                            <input type="checkbox" id="<?php echo esc_url($child_terms_link) ?>" class="child_cat_check"
                                name="child_cat_check_<?php echo esc_attr($parent_term->slug); ?>"
                                data-taxonomy_name="<?php echo esc_attr($taxonomy); ?>"
                                value="<?php echo esc_attr($parent_term->term_id); ?>">
                            <span class="prt_check_<?php echo esc_attr($taxonomyslug); ?>">
                                <label
                                    for="<?php echo esc_url($child_terms_link) ?>"><?php echo esc_html($parent_term->name . '(' . $parent_term->count . ')'); ?></label><span
                                    class="arrow">&#9660;</span>
                            </span>
                            <ul class="wcpf_child-cat wcpf_child_cats_<?php echo esc_attr($taxonomyslug); ?>">
                                <?php
                                foreach ($child_terms as $child_term) {
                                    $this->wcpf_display_subcategories_recursive($child_term, $taxonomy);
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                } else {
                    $child_terms_link = get_term_link($parent_term->term_id);
                    ?>
                        <li class="child-cat-li">
                            <input type="checkbox" id="<?php echo esc_url($child_terms_link); ?>" class="child_cat_check"
                                name="child_cat_check_<?php echo esc_attr($parent_term->slug); ?>"
                                data-taxonomy_name="<?php echo esc_attr($taxonomy); ?>"
                                value="<?php echo esc_attr($parent_term->term_id); ?>">
                            <label
                                for="<?php echo esc_url($child_terms_link); ?>"><?php echo esc_html($parent_term->name . '(' . $parent_term->count . ')'); ?>
                            </label>
                        </li>
                        <?php
                }

            }



        }


        /**
         * Display subcategories of a specified taxonomy starting from a parent term.
         *
         * This function generates an HTML list of subcategories (or terms) in a specified taxonomy,
         * starting from the given parent term and displaying all levels of subcategories recursively.
         *
         * @since 1.0.0
         * @param int    $parent_term The ID of the parent term to start displaying subcategories from.
         * @param string $taxonomy    The taxonomy slug to retrieve terms from.
         * @return string $html The HTML markup for the hierarchical list of subcategories.
         */
        public function wcpf_display_subcategories_recursive_product_cat($parent_term, $taxonomy)
        {
            $child_terms = get_terms([
                'taxonomy' => $taxonomy,
                'parent' => $parent_term->term_id,
            ]);




            if (!empty($child_terms)) {
                $pt_id = $parent_term->term_id;
                $child_terms_link = get_term_link($parent_term->term_id);
                $taxonomyslug = $pt_id;
                $this->toggle_taxonomies_function($taxonomyslug);
                ?>
                    <li class="wcpf-parent-cat-li">
                        <input type="checkbox" id="<?php echo esc_url($child_terms_link) ?>" class="child_cat_check"
                            name="child_cat_check_<?php echo esc_attr($parent_term->slug); ?>"
                            data-taxonomy_name="<?php echo esc_attr($taxonomy); ?>"
                            value="<?php echo esc_attr($parent_term->term_id); ?>" checked disabled>
                        <span class="prt_check_<?php echo esc_attr($taxonomyslug); ?>">
                            <label
                                for="<?php echo esc_url($child_terms_link) ?>"><?php echo esc_html($parent_term->name . '(' . $parent_term->count . ')'); ?></label><span
                                class="arrow">&#9660;</span>
                        </span>
                        <ul class="wcpf_child-cat wcpf_child_cats_<?php echo esc_attr($taxonomyslug); ?>">
                            <?php
                            foreach ($child_terms as $child_term) {
                                $this->wcpf_display_subcategories_recursive_product_cat($child_term, $taxonomy);
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
            } else {
                $child_terms_link = get_term_link($parent_term->term_id);
                ?>
                    <li class="child-cat-li">
                        <input type="checkbox" id="<?php echo esc_url($child_terms_link); ?>" class="child_cat_check"
                            name="child_cat_check_<?php echo esc_attr($parent_term->slug); ?>"
                            data-taxonomy_name="<?php echo esc_attr($taxonomy); ?>"
                            value="<?php echo esc_attr($parent_term->term_id); ?>" checked disabled>
                        <label
                            for="<?php echo esc_url($child_terms_link); ?>"><?php echo esc_html($parent_term->name . '(' . $parent_term->count . ')'); ?>
                        </label>
                    </li>
                    <?php
            }
        }

        /**
         * Get the count of products associated with each term in a specified taxonomy.
         *
         * This function retrieves the number of products for each term in the given taxonomy.
         * It can be used to display the number of products per category, tag, or any custom taxonomy.
         *
         * @since 1.0.0
         * @param string $taxonomy The taxonomy slug to retrieve term counts for. Defaults to 'product_cat'.
         * @return count $query->found_posts.
         */
        public function wcpf_get_product_count_by_taxonomy($taxonomy = 'product_cat')
        {


            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => get_terms(array(
                            'taxonomy' => $taxonomy,
                            'fields' => 'ids',
                            'hide_empty' => true,
                        )),
                        'include_children' => true,
                        'operator' => 'IN',
                    ),
                ),
            );

            $query = new WP_Query($args);

            return $query->found_posts;
        }

        /**
         * Get the count of products associated with each term in all WooCommerce taxonomies.
         *
         * This function retrieves the number of products associated with each term in all taxonomies
         * that are related to WooCommerce products. It returns an array where the keys are taxonomy
         * slugs and the values are arrays of term names and their respective product counts.
         *
         * @since 1.0.0
         * @return count of all products .
         */

        public function wcpf_all_get_product_counts_by_taxonomies()
        {

            $totalCount = 0;

            $taxonomies = get_object_taxonomies('product', 'objects');

            $wpcf_get_all_taxonomies_data = get_option('wcpf_custom_taxonomy');

            $filtered_taxonomy_product_counts = array();

            if (is_array($wpcf_get_all_taxonomies_data)) {

                foreach ($wpcf_get_all_taxonomies_data as $taxonomy_name => $taxonomy_data) {
                    if (isset($taxonomy_data['taxonomy_status']) && $taxonomy_data['taxonomy_status'] == 0) {
                        $filtered_taxonomy_product_counts[] = $taxonomy_data['taxonomy_name'];
                    }
                }
            }


            foreach ($taxonomies as $taxonomy) {

                if (in_array($taxonomy->name, $filtered_taxonomy_product_counts)) {

                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => $taxonomy->name,
                                'operator' => 'EXISTS',
                            ),
                        ),
                    );

                    $query = new WP_Query($args);
                    $totalCount = $totalCount + $query->found_posts;

                }
            }

            return $totalCount;
        }

        /**
         * Generates inline JavaScript for toggling taxonomy elements.
         *
         * This function outputs a JavaScript snippet that uses jQuery to toggle the visibility of 
         * child taxonomy elements when a specific checkbox is clicked. It also toggles the arrow 
         * icon to indicate the expanded or collapsed state of the taxonomy.
         *
         * @param string $taxonomyslug The slug of the taxonomy to be targeted. 
         *                             This slug is used to dynamically generate class names for the elements.
         */
        public function toggle_taxonomies_function($taxonomyslug)
        {
            ?>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery(".prt_check_<?php echo esc_attr($taxonomyslug); ?>").click(function () {
                            jQuery('.wcpf_child_cats_<?php echo esc_attr($taxonomyslug); ?>').toggle();
                            // Toggle the arrow (up or down)
                            var arrow = jQuery('.prt_check_<?php echo esc_attr($taxonomyslug); ?> .arrow');
                            arrow.text(arrow.text() === '▼' ? '▲' : '▼');
                        });
                    }); 
                </script>
                <?php
        }

        /**
         * Override the default WooCommerce shop page template.
         *
         * This function checks if the current page is the WooCommerce shop page and, if so,
         * allows for a custom template to be used. It filters the template path, replacing the 
         * default WooCommerce shop template with a custom template if it exists in the theme or plugin.
         *
         * @param string $template The path to the current template file that WooCommerce is about to load.
         * @return string $template The path to the template file that WooCommerce should load.
         */
        public function wcpf_custom_shop_page_template($template)
        {
            // Use the plugin directory path to locate the custom template
            $custom_template = plugin_dir_path(__FILE__) . 'archive-product.php';
            if (is_shop()) {
                // Check if the custom template file exists
                if (get_option('wpcf_shop_template_override')) {
                    if (file_exists($custom_template)) {
                        return $custom_template;
                    }
                }
            } elseif (is_product_category()) {
                if (get_option('wpcf_category_template_override')) {
                    if (file_exists($custom_template)) {
                        return $custom_template;
                    }
                }
            }

            // Return the original template if not on the shop page
            return $template;
        }






    }
}

// Instantiate the WCPFCF_shortcodes_shop_page class to enable its functionality on the shop page.
// This class is likely responsible for handling custom shortcodes or other custom functionality
// specific to the WooCommerce shop page.

new WCPFCF_shortcodes_shop_page();


