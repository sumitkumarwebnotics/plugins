<?php
if (!class_exists('WCPFCF_Scripts')) {
    class WCPFCF_Scripts
    {

        public function __construct()
        {
            add_action('admin_enqueue_scripts', [$this, 'wcpf_enqueue_admin_scripts']);
            add_action('wp_enqueue_scripts', [$this, 'wcpf_enqueue_frontend_scripts']);
        }

        /**
        * Enqueue admin styles and scripts.
         *
         * This function is responsible for including CSS and JavaScript files in the admin area.
         * It enqueues the necessary stylesheets and scripts required for the plugin's functionality
         * within the WordPress admin interface.
         *
         * The function enqueues a custom CSS file, FontAwesome, Bootstrap, and jQuery. It also enqueues
         * a custom JavaScript file with jQuery as a dependency, and localizes it with an AJAX URL and nonce.
         *
         * Additionally, it checks for custom font options and enqueues Google Fonts if specified.
         *
         * @return void
        */
        public function wcpf_enqueue_admin_scripts()
        {
            //$plugin_url = plugin_dir_url(__FILE__);
            $plugin_url = WCPFCF_PLUGIN_DIR_URL;
            // Enqueue plugin's CSS file
            wp_enqueue_style('wcpf-style', $plugin_url . 'assets/css/style.css');

            // Enqueue FontAwesome CSS
            wp_enqueue_style('wcpf-fontawesome', 'https://use.fontawesome.com/releases/v5.7.1/css/all.css');

            // Enqueue Bootstrap CSS
            wp_enqueue_style('wcpf-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css');

            // Enqueue jQuery (WordPress includes jQuery by default, so no need to manually include it from CDN)
            wp_enqueue_script('jquery');

            // Enqueue custom JS with dependency on jQuery
            wp_enqueue_script('wcpf-custom-js', $plugin_url . 'assets/js/custom.js', ['jquery'], '2.5.1', true);

            // Localize the script with the ajax URL
            wp_localize_script('wcpf-custom-js', 'ajax_object', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'ajax_nonce' => wp_create_nonce('web_secure_webnotics')
            ]);

            $options = get_option('wpcf_customize_style_options');
            $button_font_family = isset($options['button_font_family']) ? $options['button_font_family'] : '';
            $heading_font_family = isset($options['heading_font_family']) ? $options['heading_font_family'] : '';

            $fonts = array();

            if ($button_font_family) {
                $fonts[] = $button_font_family;
            }


            if ($heading_font_family) {
                $fonts[] = $heading_font_family;
            }


            if (!empty($fonts)) {
                $fonts = array_unique($fonts);

                $font_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', array_map('urlencode', $fonts)) . '&display=swap';
                wp_enqueue_style('wpcf-google-fonts', $font_url, array(), null);
            }

            

        }


         /**
         * Enqueue styles and scripts for the frontend.
         *
         * This function is responsible for including the necessary CSS and JavaScript files on the frontend.
         * It enqueues the plugin's custom styles, jQuery, and additional libraries like Chosen, jQuery UI Slider, and noUiSlider.
         * The function also handles the inclusion of Google Fonts based on custom options.
         *
         * @return void
         */
        public function wcpf_enqueue_frontend_scripts()
        {
            //$plugin_url = plugin_dir_url(__FILE__);
            $plugin_url = WCPFCF_PLUGIN_DIR_URL;
            wp_enqueue_style('style2', $plugin_url . 'assets/css/style.css');
            wp_enqueue_style('chosen_css', $plugin_url . 'assets/css/chosen.css');
            wp_enqueue_script('custom_js', $plugin_url . 'assets/js/custom.js', ['jquery'], '2.5.1');
            wp_enqueue_script('chosen_js', $plugin_url . 'assets/js/chosen.js', ['jquery'], '2.5.1');
            wp_localize_script('custom_js', 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php'), 'ajax_nonce' => wp_create_nonce('web_secure_webnotics')]);

            // for range slider

            wp_enqueue_script('jquery-ui-slider');
            wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

            // Alternatively, for noUiSlider
            wp_enqueue_script('nouislider-js', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.4.0/nouislider.min.js', array(), null, true);
            wp_enqueue_style('nouislider-css', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.4.0/nouislider.min.css');
            wp_enqueue_style('google-font-custom-css', 'https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Open+Sans:wght@100;300;400;500;700;900&family=Lato:wght@100;300;400;500;700;900&display=swap');
         
            $options = get_option('wpcf_customize_style_options');
            $button_font_family = isset($options['button_font_family']) ? $options['button_font_family'] : '';
            $heading_font_family = isset($options['heading_font_family']) ? $options['heading_font_family'] : '';

            $fonts = array();

            if ($button_font_family) {
                $fonts[] = $button_font_family;
            }


            if ($heading_font_family) {
                $fonts[] = $heading_font_family;
            }


            if (!empty($fonts)) {
                $fonts = array_unique($fonts);

                $font_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', array_map('urlencode', $fonts)) . '&display=swap';
                wp_enqueue_style('wpcf-google-fonts', $font_url, array(), null);
            }

        }
    }

}
new WCPFCF_Scripts();