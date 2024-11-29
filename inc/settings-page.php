<?php

// Create the settings page.
function my_plugin_add_settings_page()
{
    add_menu_page(
        'My Plugin Settings', // Page title
        'My Plugin',          // Menu title
        'manage_options',     // Capability
        'my-plugin-settings', // Menu slug
        'my_plugin_render_settings_page', // Callback function
        'dashicons-admin-generic', // Icon
        20                    // Position
    );
}
add_action('admin_menu', 'my_plugin_add_settings_page');

// Render the settings page content.
function my_plugin_render_settings_page()
{
?>
    <div class="wrap">
        <h1>My Plugin Settings</h1>
        <div class="tabs">
            <button class="tab" onclick="openTab(event, 'tab1')">Tab 1</button>
            <button class="tab" onclick="openTab(event, 'tab2')">Tab 2</button>
            <button class="tab" onclick="openTab(event, 'tab3')">Tab 3</button>
        </div>

        <div id="tab1" class="tabcontent">
            <h3>Tab 1 Content</h3>
            <p>This is the content of tab 1.</p>
        </div>

        <div id="tab2" class="tabcontent">
            <h3>Tab 2 Content</h3>
            <p>This is the content of tab 2.</p>
        </div>

        <div id="tab3" class="tabcontent">
            <h3>Tab 3 Content</h3>
            <p>This is the content of tab 3.</p>
        </div>
    </div>
<?php
}
