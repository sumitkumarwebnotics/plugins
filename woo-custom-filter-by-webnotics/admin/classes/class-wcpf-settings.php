<?php
if (!class_exists('WCPFCF_Settings')) {
    class WCPFCF_Settings
    {

        public function __construct()
        {
            add_action('admin_init', [$this, 'wpcf_register_settings']);
        }

        /**
         * Registers plugin settings and adds settings sections and fields.
         *
         * This function sets up the various settings used by the plugin, including options
         * for shop templates, filter options, and styling. It also defines the settings sections
         * and fields for these options, allowing them to be configured through the WordPress admin
         * settings page.
         *
         * @return void
        */
        public function wpcf_register_settings()
        {
            // Register settings for shop template override
            register_setting('wpcf_shop_template_override_group', 'wpcf_shop_template_override');
            register_setting('wpcf_shop_template_override_group', 'wpcf_category_template_override');
            register_setting('wpcf_shop_template_override_group', 'wpcf_remove_content_after_plugin_removal');
            register_setting('wpcf_shop_template_override_group', 'wpcf_enable_sticky_filter_form');

            // Register settings for filter options
            register_setting('wpcf_filter_option_group', 'wpcf_search_by_keyword_option');
            register_setting('wpcf_filter_option_group', 'wpcf_search_by_price_option');
            register_setting('wpcf_filter_option_group', 'wpcf_filter_by_rating_option');
            register_setting('wpcf_filter_option_group', 'wpcf_filter_by_tag_option');

            // Register settings for styling
            register_setting('wpcf_customize_style_group', 'wpcf_customize_style_options');



            // Add settings section
            add_settings_section(
                'wpcf_shop_template_override_section',  // ID
                '',                                     // Title (hidden)
                null,                                   // Callback (not needed)
                'shop-template-override'                // Page
            );

            // Add the checkbox for overriding the shop template
            add_settings_field(
                'wpcf_shop_template_override_checkbox', // ID
                __("Do you want to override the shop template?", "woo-custom-filter-by-webnotics"), // Title
                [$this, 'wpcf_shop_template_override_checkbox_render'], // Callback function
                'shop-template-override',               // Page
                'wpcf_shop_template_override_section'   // Section
            );

            // Add the checkbox for enable sticky filter form on shop page
            add_settings_field(
                'wpcf_enable_sticky_filter_form_checkbox', // ID
                __("Do you want to enable sticky filter form?", "woo-custom-filter-by-webnotics"), // Title
                [$this, 'wpcf_enable_sticky_filter_form_checkbox_render'], // Callback function
                'shop-template-override',               // Page
                'wpcf_shop_template_override_section'   // Section
            );


            // Add the checkbox for overriding the category template
            add_settings_field(
                'wpcf_category_template_override_checkbox', // ID
                __("Do you want to override the category page template?", "woo-custom-filter-by-webnotics"), // Title
                [$this, 'wpcf_category_template_override_checkbox_render'], // Callback function
                'shop-template-override',               // Page
                'wpcf_shop_template_override_section'   // Section
            );

            // Add the checkbox for removing content after plugin removal
            add_settings_field(
                'wpcf_remove_content_after_plugin_removal_checkbox', // ID
                __("Do you want to remove content after removing the plugin?", "woo-custom-filter-by-webnotics"), // Title
                [$this, 'wpcf_remove_content_after_plugin_removal_checkbox_render'], // Callback function
                'shop-template-override',               // Page
                'wpcf_shop_template_override_section'   // Section
            );





            // Add settings section for Filter Option
            add_settings_section(
                'wpcf_filter_option_section',
                '',
                null,
                'filter-option'
            );

            // Add Filter Option fields
            add_settings_field(
                'wpcf_search_by_keyword_option_checkbox',
                __("Enable input box search by keyword?", "woo-custom-filter-by-webnotics"),
                [$this, 'wpcf_search_by_keyword_option_checkbox_render'],
                'filter-option',
                'wpcf_filter_option_section'
            );

            add_settings_field(
                'wpcf_search_by_price_option_checkbox',
                __("Enable filter by price?", "woo-custom-filter-by-webnotics"),
                [$this, 'wpcf_search_by_price_option_checkbox_render'],
                'filter-option',
                'wpcf_filter_option_section'
            );

            add_settings_field(
                'wpcf_filter_by_rating_option_checkbox',
                __("Enable filter by rating?", "woo-custom-filter-by-webnotics"),
                [$this, 'wpcf_filter_by_rating_option_checkbox_render'],
                'filter-option',
                'wpcf_filter_option_section'
            );

            add_settings_field(
                'wpcf_filter_by_tag_option_checkbox',
                __("Enable filter by tag?", "woo-custom-filter-by-webnotics"),
                [$this, 'wpcf_filter_by_tag_option_checkbox_render'],
                'filter-option',
                'wpcf_filter_option_section'
            );



            add_settings_section(
                'wpcf-customize-style-settings-section',
                '',
                null,
                'wpcf-customize-style-settings'
            );


            add_settings_field(
                'wpcf_customize_style_button_text_color', // ID
                __('Button Text Color', 'woo-custom-filter-by-webnotics') . ' <span class="tooltip-icon" title="' . __('Choose the color for the button text.', 'woo-custom-filter-by-webnotics') . '"><i class="far fa-question-circle"></i></span>', // Title
                [$this, 'wpcf_customize_style_button_text_color_callback'], // Callback
                'wpcf-customize-style-settings', // Page
                'wpcf-customize-style-settings-section' // Section
            );


            add_settings_field(
                'wpcf_customize_style_button_background_color', // ID
                __('Button background Color', 'woo-custom-filter-by-webnotics') . ' <span class="tooltip-icon" title="' . __('Choose the Button background Color.', 'woo-custom-filter-by-webnotics') . '"><i class="far fa-question-circle"></i></span>', // Title
                [$this, 'wpcf_customize_style_button_background_color_callback'], // Callback
                'wpcf-customize-style-settings', // Page
                'wpcf-customize-style-settings-section' // Section
            );


            add_settings_field(
                'wpcf_customize_style_button_font_family', // ID
                __('Button Font Family', 'woo-custom-filter-by-webnotics') . ' <span class="tooltip-icon" title="' . __('Choose the Button Font Family.', 'woo-custom-filter-by-webnotics') . '"><i class="far fa-question-circle"></i></span>', // Title
                [$this, 'wpcf_customize_style_button_font_family_callback'], // Callback
                'wpcf-customize-style-settings', // Page
                'wpcf-customize-style-settings-section' // Section
            );

            add_settings_field(
                'wpcf_customize_style_button_font_size', // ID
                __('Button Font Size in px', 'woo-custom-filter-by-webnotics') . ' <span class="tooltip-icon" title="' . __('Insert the Button Font Size.', 'woo-custom-filter-by-webnotics') . '"><i class="far fa-question-circle"></i></span>', // Title
                [$this, 'wpcf_customize_style_button_font_size_callback'], // Callback
                'wpcf-customize-style-settings', // Page
                'wpcf-customize-style-settings-section' // Section
            );

            // for heading 

            add_settings_field(
                'wpcf_customize_style_heading_text_color', // ID
                __('Heading Text Color', 'woo-custom-filter-by-webnotics') . ' <span class="tooltip-icon" title="' . __('Choose the heading Text Color.', 'woo-custom-filter-by-webnotics') . '"><i class="far fa-question-circle"></i></span>', // Title
                [$this, 'wpcf_customize_style_heading_text_color_callback'], // Callback
                'wpcf-customize-style-settings', // Page
                'wpcf-customize-style-settings-section' // Section
            );


            add_settings_field(
                'wpcf_customize_style_heading_font_family', // ID
                __('Heading Font Family', 'woo-custom-filter-by-webnotics') . ' <span class="tooltip-icon" title="' . __('Choose the heading Font Family.', 'woo-custom-filter-by-webnotics') . '"><i class="far fa-question-circle"></i></span>', // Title
                [$this, 'wpcf_customize_style_heading_font_family_callback'], // Callback
                'wpcf-customize-style-settings', // Page
                'wpcf-customize-style-settings-section' // Section
            );

            add_settings_field(
                'wpcf_customize_style_heading_font_size', // ID
                __('Heading Font Size in px', 'woo-custom-filter-by-webnotics') . ' <span class="tooltip-icon" title="' . __('Insert the heading Font Size.', 'woo-custom-filter-by-webnotics') . '"><i class="far fa-question-circle"></i></span>', // Title
                [$this, 'wpcf_customize_style_heading_font_size_callback'], // Callback
                'wpcf-customize-style-settings', // Page
                'wpcf-customize-style-settings-section' // Section
            );

            add_settings_field(
                'wpcf_customize_style_price_range', // ID
                __('Choose the color for price range slider', 'woo-custom-filter-by-webnotics') . ' <span class="tooltip-icon" title="' . __('Choose the color for price range slider.', 'woo-custom-filter-by-webnotics') . '"><i class="far fa-question-circle"></i></span>', // Title
                [$this, 'wpcf_customize_style_price_range_callback'], // Callback
                'wpcf-customize-style-settings', // Page
                'wpcf-customize-style-settings-section' // Section
            );

            add_settings_field(
                'wpcf_customize_style_google_api', // ID
                __('Google font family API', 'woo-custom-filter-by-webnotics') . ' <span class="tooltip-icon" title="' . __('Enter Google font family API', 'woo-custom-filter-by-webnotics') . '"><i class="far fa-question-circle"></i></span>', // Title
                [$this, 'wpcf_customize_style_google_api_callback'], // Callback
                'wpcf-customize-style-settings', // Page
                'wpcf-customize-style-settings-section' // Section
            );



        }

        /**
         * Render the checkbox for the "Shop Template Override" option in the settings page.
         *
         * This method outputs an HTML checkbox input field for the "Shop Template Override" 
         * option in the plugin's settings page. It retrieves the current value of the option 
         * from the database and marks the checkbox as checked if the option is enabled (value is 1).
         *
         * @return void
         */
        // Callback function to render the first checkbox
        public function wpcf_shop_template_override_checkbox_render()
        {
            $option = get_option('wpcf_shop_template_override');
            ?>
            <input type="checkbox" name="wpcf_shop_template_override" value="1" <?php checked(1, $option, true); ?> />
            <?php
        }

        /**
         * Render the checkbox for the "Enable Sticky Filter " option in the settings page.
         *
         * This method outputs an HTML checkbox input field for the "Enable Sticky Filter " 
         * option in the plugin's settings page. It retrieves the current value of the option 
         * from the database and marks the checkbox as checked if the option is enabled (value is 1).
         *
         * @return void
         */
        // Callback function to render the first checkbox
        public function wpcf_enable_sticky_filter_form_checkbox_render()
        {
            $option = get_option('wpcf_enable_sticky_filter_form');
            ?>
            <input type="checkbox" name="wpcf_enable_sticky_filter_form" value="1" <?php checked(1, $option, true); ?> />
            <?php
        }

        /**
         * Render the checkbox for the "Category Template Override" option in the settings page.
         *
         * This method outputs an HTML checkbox input field for the "Category Template Override" 
         * option in the plugin's settings page. It retrieves the current value of the option 
         * from the database and marks the checkbox as checked if the option is enabled (value is 1).
         *
         * @return void
         */
        // Callback function to render the Second checkbox
        public function wpcf_category_template_override_checkbox_render()
        {
            $option = get_option('wpcf_category_template_override');
            ?>
            <input type="checkbox" name="wpcf_category_template_override" value="1" <?php checked(1, $option, true); ?> />
            <?php
        }

        /**
         * Render the checkbox for the "Remove Content After Plugin Removal" option in the settings page.
         *
         * This method outputs an HTML checkbox input field for the "Remove Content After Plugin Removal" 
         * option in the plugin's settings page. It retrieves the current value of the option 
         * from the database and marks the checkbox as checked if the option is enabled (value is 1).
         *
         * @return void
         */
        // Callback function to render the second checkbox
        public function wpcf_remove_content_after_plugin_removal_checkbox_render()
        {
            $option = get_option('wpcf_remove_content_after_plugin_removal');
            ?>
            <input type="checkbox" name="wpcf_remove_content_after_plugin_removal" value="1" <?php checked(1, $option, true); ?> />
            <?php
        }

        /**
         * Render the checkbox for the "Search by Keyword" option in the settings page.
         *
         * This method outputs an HTML checkbox input field for the "Search by Keyword" 
         * option in the plugin's settings page. It retrieves the current value of the option 
         * from the database and marks the checkbox as checked if the option is enabled (value is 1).
         *
         * @return void
         */

        // Callback function to render the filter option checkbox
        public function wpcf_search_by_keyword_option_checkbox_render()
        {
            $option = get_option('wpcf_search_by_keyword_option');
            ?>
            <input type="checkbox" name="wpcf_search_by_keyword_option" value="1" <?php checked(1, $option, true); ?> />
            <?php
        }

        /**
         * Render the checkbox for the "Search by Price" option in the settings page.
         *
         * This method outputs an HTML checkbox input field for the "Search by Price" 
         * option in the plugin's settings page. It retrieves the current value of the option 
         * from the database and marks the checkbox as checked if the option is enabled (value is 1).
         *
         * @return void
         */
        public function wpcf_search_by_price_option_checkbox_render()
        {
            $option = get_option('wpcf_search_by_price_option');
            ?>
            <input type="checkbox" name="wpcf_search_by_price_option" value="1" <?php checked(1, $option, true); ?> />
            <?php
        }

        /**
         * Render the checkbox for the "Filter by Rating" option in the settings page.
         *
         * This method outputs an HTML checkbox input field for the "Filter by Rating" 
         * option in the plugin's settings page. It retrieves the current value of the option 
         * from the database and marks the checkbox as checked if the option is enabled (value is 1).
         *
         * @return void
         */
        public function wpcf_filter_by_rating_option_checkbox_render()
        {
            $option = get_option('wpcf_filter_by_rating_option');
            ?>
            <input type="checkbox" name="wpcf_filter_by_rating_option" value="1" <?php checked(1, $option, true); ?> />
            <?php
        }

        /**
         * Render the checkbox for the "Filter by Tag" option in the settings page.
         *
         * This method outputs an HTML checkbox input field for the "Filter by Tag" 
         * option in the plugin's settings page. It retrieves the current value of the option 
         * from the database and marks the checkbox as checked if the option is enabled (value is 1).
         *
         * @return void
         */
        public function wpcf_filter_by_tag_option_checkbox_render()
        {
            $option = get_option('wpcf_filter_by_tag_option');
            ?>
            <input type="checkbox" name="wpcf_filter_by_tag_option" value="1" <?php checked(1, $option, true); ?> />
            <?php
        }

        /**
         * Render the color picker input for the "Button Text Color" option in the settings page.
         *
         * This method outputs an HTML color input field that allows users to select the text color 
         * for buttons in the plugin's settings page. It retrieves the current color value from the 
         * database and displays it in the input field. If no color is set, the input will be empty, 
         * allowing users to select a new color.
         *
         * @return void
         */

        // callback functions for customize style

        public function wpcf_customize_style_button_text_color_callback()
        {
            $options = get_option('wpcf_customize_style_options');
            ?>
            <input type="color" name="wpcf_customize_style_options[button_text_color]"
                value="<?php echo esc_attr($options['button_text_color'] ?? ''); ?>" placeholder="#000000" />
            <?php
        }

        /**
         * Render the color picker input for the "Button Background Color" option in the settings page.
         *
         * This method outputs an HTML color input field that allows users to select the background color 
         * for buttons in the plugin's settings page. It retrieves the current background color value from 
         * the database and displays it in the input field. If no color is set, the input will be empty, 
         * allowing users to choose a new color.
         *
         * @return void
         */
        public function wpcf_customize_style_button_background_color_callback()
        {
            $options = get_option('wpcf_customize_style_options');
            ?>
            <input type="color" name="wpcf_customize_style_options[button_background_color]"
                value="<?php echo esc_attr($options['button_background_color'] ?? ''); ?>" placeholder="#000000" />
            <?php
        }

        /**
         * Render the number input for the "Button Font Size" option in the settings page.
         *
         * This method outputs an HTML number input field that allows users to specify the font size 
         * for buttons in the plugin's settings page. It retrieves the current font size value from the 
         * database and displays it in the input field. If no font size is set, the input will be empty, 
         * allowing users to enter a new value.
         *
         * @return void
         */

        public function wpcf_customize_style_button_font_size_callback()
        {
            $options = get_option('wpcf_customize_style_options');
            ?>
            <input type="number" name="wpcf_customize_style_options[button_font_size]"
                value="<?php echo esc_attr($options['button_font_size'] ?? ''); ?>" placeholder="10px (In pixel)" />
            <?php
        }

        /**
         * Render the select dropdown for the "Button Font Family" option in the settings page.
         *
         * This method outputs an HTML select dropdown that allows users to choose the font family 
         * for buttons in the plugin's settings page. It retrieves the current font family value from 
         * the database, fetches a list of available Google fonts, and populates the dropdown with these 
         * font options. The current selection is set based on the stored value.
         *
         * @return void
         */

        public function wpcf_customize_style_button_font_family_callback()
        {
            $options = get_option('wpcf_customize_style_options');
            $fonts = $this->wpcf_fetch_google_fonts();
            $selected_font = $options['button_font_family'] ?? '';

            echo '<select name="wpcf_customize_style_options[button_font_family]">';
            foreach ($fonts as $font) {
                $font_family = $font['family'];
                printf(
                    '<option value="%s" %s>%s</option>',
                    esc_attr($font_family),
                    selected($selected_font, $font_family, false),
                    esc_html($font_family)
                );
            }
            echo '</select>';

        }

        /**
         * Render the color input field for the "Heading Text Color" option in the settings page.
         *
         * This method generates an HTML color input field, allowing users to choose the text color 
         * for headings on the plugin's settings page. It retrieves the current color value from the 
         * database and sets it as the default value in the input field. If no color is set, the input 
         * will be empty, allowing users to pick a new color.
         *
         * @return void
         */

        public function wpcf_customize_style_heading_text_color_callback()
        {
            $options = get_option('wpcf_customize_style_options');
            ?>
            <input type="color" name="wpcf_customize_style_options[heading_text_color]"
                value="<?php echo esc_attr($options['heading_text_color'] ?? ''); ?>" placeholder="#000000" />
            <?php
        }

        /**
         * Render the number input field for the "Heading Font Size" option in the settings page.
         *
         * This method generates an HTML number input field, allowing users to specify the font size 
         * for headings on the plugin's settings page. It retrieves the current font size value from the 
         * database and sets it as the default value in the input field. The input field allows users to 
         * enter a new font size in pixels.
         *
         * @return void
         */

        public function wpcf_customize_style_heading_font_size_callback()
        {
            $options = get_option('wpcf_customize_style_options');
            ?>
            <input type="number" name="wpcf_customize_style_options[heading_font_size]"
                value="<?php echo esc_attr($options['heading_font_size'] ?? ''); ?>" placeholder="10px (In pixel)" />
            <?php
        }

        /**
         * Render the color input field for the "Price Range Color" option in the settings page.
         *
         * This method generates an HTML color input field, allowing users to select the color 
         * used for the price range display in the plugin. It retrieves the current color value from the 
         * database and sets it as the default value in the input field. If no color is set, the input 
         * will show a placeholder color suggestion.
         *
         * @return void
         */
        public function wpcf_customize_style_price_range_callback()
        {
            $options = get_option('wpcf_customize_style_options');
            ?>
            <input type="color" name="wpcf_customize_style_options[price_range_color]"
                value="<?php echo esc_attr($options['price_range_color'] ?? ''); ?>" placeholder="#3f42b7" />
            <?php
        }
        public function wpcf_customize_style_google_api_callback()
        {
            $options = get_option('wpcf_customize_style_options');
            ?>
            <input type="text" name="wpcf_customize_style_options[google_api]"
                value="<?php echo esc_attr($options['google_api'] ?? ''); ?>" placeholder="Enter google font API key" style="width: 100%; max-width: 350px;" />
            <?php
        }

        /**
         * Render the dropdown select field for the "Heading Font Family" option in the settings page.
         *
         * This method generates an HTML select field, allowing users to choose a font family for headings 
         * from a list of available Google Fonts. It retrieves the currently selected font family from 
         * the database and sets it as the default selected option in the dropdown. If no font family is 
         * set, the dropdown will show the available options for the user to choose from.
         *
         * @return void
         */

        public function wpcf_customize_style_heading_font_family_callback()
        {
            $options = get_option('wpcf_customize_style_options');
            $fonts = $this->wpcf_fetch_google_fonts();
            $selected_font = $options['heading_font_family'] ?? '';

            echo '<select name="wpcf_customize_style_options[heading_font_family]">';
            foreach ($fonts as $font) {
                $font_family = $font['family'];
                printf(
                    '<option value="%s" %s>%s</option>',
                    esc_attr($font_family),
                    selected($selected_font, $font_family, false),
                    esc_html($font_family)
                );
            }
            echo '</select>';

        }

        /**
         * Fetches a list of Google Fonts using the Google Fonts API.
         *
         * This method makes a request to the Google Fonts API to retrieve a list of available Google Fonts.
         * It uses the WordPress `wp_remote_get` function to perform the HTTP GET request. The response is 
         * processed and returned as an array of fonts. If there is an error during the request or if the 
         * response does not contain the expected data, an empty array is returned.
         *
         * @return array An array of font items from the Google Fonts API. Each item contains details about a font.
         */
        public function wpcf_fetch_google_fonts()
        {
            $options = get_option('wpcf_customize_style_options');
            $api_key = (isset($options['google_api']))?$options['google_api']:"AIzaSyBY4-opoK-LQBHrlVK5n1fHUn32K0UHggc";
            $api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $api_key;

            // Use wp_remote_get to fetch the Google Fonts data
            $response = wp_remote_get($api_url);

            if (is_wp_error($response)) {
                return []; // Return an empty array if there's an error
            }

            $body = wp_remote_retrieve_body($response);
            $fonts_data = json_decode($body, true);

            // Return the array of fonts or an empty array if the request fails
            return isset($fonts_data['items']) ? $fonts_data['items'] : [];
        }




    }


}

new WCPFCF_Settings();