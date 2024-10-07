<div class="wrap sting">
    <h1><?= __("Setting Page","woo-custom-filter-by-webnotics"); ?></h1>
    <?php
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=woo-custom-filter-settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?= __("General Settings","woo-custom-filter-by-webnotics"); ?></a>
        <a href="?page=woo-custom-filter-settings&tab=filter-option" class="nav-tab <?php echo $active_tab == 'filter-option' ? 'nav-tab-active' : ''; ?>"><?= __("Filter Option","woo-custom-filter-by-webnotics"); ?></a>
        <a href="?page=woo-custom-filter-settings&tab=woo-custom-filter-styles" class="nav-tab <?php echo $active_tab == 'woo-custom-filter-styles' ? 'nav-tab-active' : ''; ?>"><?= __("Customize style","woo-custom-filter-by-webnotics"); ?></a>
    </h2>

    <form method="post" action="options.php">
        <?php
        if ($active_tab == 'filter-option') {
            settings_fields('wpcf_filter_option_group');
            do_settings_sections('filter-option');
        }else if($active_tab == 'woo-custom-filter-styles'){
        
            settings_fields('wpcf_customize_style_group');
            do_settings_sections('wpcf-customize-style-settings');
        
        }
        
        else {
            settings_fields('wpcf_shop_template_override_group');
            do_settings_sections('shop-template-override');
        }
        submit_button();
        ?>
    </form>
</div>
