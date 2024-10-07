<style>
.woo-docs {
    border: 1px solid #ddd;
    margin: 20px;
    padding: 20px;
    border-radius: 12px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Arial', sans-serif;
    color: #333;
}

.woo-docs h2 {
    color: #3f42b7;
    font-size: 32px;
    margin-bottom: 10px;
    letter-spacing: 1.5px;
}

.woo-docs .head {
    text-align: center;
    margin-bottom: 20px;
}

.woo-docs p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 15px;
}

.woo-docs h5 {
    color: #444;
    font-size: 24px;
    margin-top: 25px;
    margin-bottom: 20px;
    border-bottom: 1px solid #d3d3d3;
    padding-bottom: 5px;
}

.woo-docs ul {
    list-style: none;
    padding-left: 20px;
    margin-bottom: 20px;
}

.woo-docs ul li {
    font-size: 16px;
    margin-bottom: 10px;
    position: relative;
    padding-left: 25px;
}

.woo-docs ul li::before {
    content: "\2022";
    color: #000;
    font-weight: bold;
    font-size: 20px;
    position: absolute;
    left: 0;
    top: 0;
}

.woo-docs ul li strong {
    color: #000;
    font-weight: bold;
}

.woo-docs ul ul {
    margin-top: 10px;
}

.woo-docs ul ul li {
    font-size: 15px;
    color: #555;
}

.woo-docs ul ul li::before {
    content: "\25E6";
    color: #777;
    font-size: 16px;
}

.woo-docs ul[style] {
    list-style: circle;
    padding-left: 40px;
}
.woo-docs h6 {
    font-size: 19px;
}
</style>

<div class="wrap woo-docs">
    <div class="head">
        <h2><?= __("Product filter for custom field and taxonomy Documentation","woo-custom-filter-by-webnotics"); ?></h2>
        <p><?= __("Welcome to the documentation for WooCustomFilter Plugin.","woo-custom-filter-by-webnotics"); ?> <?= __("Here you will find information about custom fields","woo-custom-filter-by-webnotics"); ?>, <?= __("taxonomies","woo-custom-filter-by-webnotics"); ?>, <?= __("and filters.","woo-custom-filter-by-webnotics"); ?></p>
    </div>
    

    <h5><?= __("Custom Fields","woo-custom-filter-by-webnotics"); ?></h5>
    <p><?= __("My Plugin allows you to create custom fields.","woo-custom-filter-by-webnotics"); ?> <?= __("Here’s how you can use them:","woo-custom-filter-by-webnotics"); ?></p>
    <ul>
        <li><strong><?= __("Field Name","woo-custom-filter-by-webnotics"); ?>:</strong> <?= __("Enter unique field name for custom field.","woo-custom-filter-by-webnotics"); ?></li>
        <li><strong><?= __("Field Type","woo-custom-filter-by-webnotics"); ?>:</strong> <?= __("Select field type for custom field like type:Radio , Input, Checkbox.....","woo-custom-filter-by-webnotics"); ?></li>
    </ul>

    <h5><?= __("Custom Taxonomies","woo-custom-filter-by-webnotics"); ?></h5>
    <p><?= __("My Plugin supports custom taxonomies.","woo-custom-filter-by-webnotics"); ?> <?= __("Here’s how you can manage them","woo-custom-filter-by-webnotics"); ?>:</p>
    <ul>
        <li><strong><?= __("Taxonomy Name","woo-custom-filter-by-webnotics"); ?>:</strong> <?= __("Enter unique field name for taxonomies","woo-custom-filter-by-webnotics"); ?>.</li>
    </ul>

    <h5><?= __("Custom Filters","woo-custom-filter-by-webnotics"); ?></h5>
    <p><?= __("My Plugin includes custom filters. Here’s how you can apply them","woo-custom-filter-by-webnotics"); ?>:</p>
    <ul>
        <li><strong><?= __("Settings for override shop template","woo-custom-filter-by-webnotics"); ?>:</strong> <?= __("After install and activate plugin","woo-custom-filter-by-webnotics"); ?>. <?= __("Go to settings in custom filter menu and check checkbox and save it.","woo-custom-filter-by-webnotics"); ?>.</li>

    </ul>
    <h5><?= __("Plugin Installation and Activation Guide","woo-custom-filter-by-webnotics"); ?></h5>
    <h6><?= __("1. Downloading the Plugin","woo-custom-filter-by-webnotics"); ?></h6>
    <ul>
        <li> <?= __("From the WordPress Repository Navigate to the WordPress Plugin Repository","woo-custom-filter-by-webnotics"); ?>:</li>
        <li><?= __("Go to the WordPress Plugin Directory. Search for the Plugin","woo-custom-filter-by-webnotics"); ?>:</li>
        <li><?= __("Use the search bar to find the plugin by name","woo-custom-filter-by-webnotics"); ?> (<?= __("Product filter based on custom field and custom taxonomy for woocommerce Upgraded","woo-custom-filter-by-webnotics"); ?>).<?= __("Download the Plugin","woo-custom-filter-by-webnotics"); ?>:</li>
        <li><?= __("Click on the plugin title to view its details. Click the Download button to download the .zip file of the plugin to your computer.","woo-custom-filter-by-webnotics"); ?></li>
    </ul>
    <h6><?= __("2. Installing the Plugin","woo-custom-filter-by-webnotics"); ?></h6>
    <ul>
        <li><?= __("Via the WordPress Admin Dashboard Log in to Your WordPress Admin Dashboard","woo-custom-filter-by-webnotics"); ?>:</li>
        <li><?= __("Enter your admin credentials and log in to your WordPress site. Navigate to the Plugins Page","woo-custom-filter-by-webnotics"); ?>:</li>
        <li><?= __("Go to Plugins > Add New. Upload the Plugin","woo-custom-filter-by-webnotics"); ?>:</li>
        <li><?= __("Click the Upload Plugin button at the top of the page. Click Choose File, select the .zip file you downloaded, and click Install Now. Activate the Plugin","woo-custom-filter-by-webnotics"); ?>:</li>
        <li><?= __("Once the plugin is installed, click the Activate Plugin link.","woo-custom-filter-by-webnotics"); ?></li>
        <li><?= __("Via FTP/SFTP Connect to Your Server: Use an FTP/SFTP client (e.g., FileZilla) to connect to your web server. Upload the Plugin","woo-custom-filter-by-webnotics"); ?>:</li>
        <li><?= __("Navigate to the /wp-content/plugins/ directory. Upload the extracted plugin folder (not the .zip file) into this directory. Activate the Plugin:","woo-custom-filter-by-webnotics"); ?></li>
        <li><?= __("Log in to your WordPress Admin Dashboard. Go to Plugins > Installed Plugins. Find the plugin in the list and click Activate.","woo-custom-filter-by-webnotics"); ?></li>
    </ul>
    <h6><?= __("3. Activating the Plugin","woo-custom-filter-by-webnotics"); ?></h6>
    <ul>
        <li><?= __("Log in to Your WordPress Admin Dashboard:","woo-custom-filter-by-webnotics"); ?></li>
        <li><?= __("Enter your admin credentials and access the dashboard. Go to the Plugins Page:","woo-custom-filter-by-webnotics"); ?></li>
        <li><?= __("Navigate to Plugins > Installed Plugins. Locate the Plugin:","woo-custom-filter-by-webnotics"); ?></li>
        <li><?= __("Find the newly installed plugin in the list.Activate the Plugin:","woo-custom-filter-by-webnotics"); ?></li>
        <li><?= __("Click the Activate link under the plugins name. Verify Activation:","woo-custom-filter-by-webnotics"); ?></li>
        <li><?= __("Ensure that the plugin is now listed as active and configured properly:","woo-custom-filter-by-webnotics"); ?></li>
    </ul>
</div>