<?php

/**
 * Plugin Name: My Plugin
 * Description: A plugin with a custom settings page that loads CSS only on that page.
 * Version: 1.0
 * Author: Your Name
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


define('MY_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once plugin_dir_path(__FILE__) . 'inc/settings-page.php';

// Enqueue the CSS only on the settings page.
function my_plugin_enqueue_admin_styles($hook_suffix)
{
    // Check if we are on the plugin's settings page.
    if ($hook_suffix === 'toplevel_page_my-plugin-settings') {
        wp_enqueue_style(
            'my-plugin-admin-styles',
            plugin_dir_url(__FILE__) . 'dist/bundle.css',
            [],
            filemtime(plugin_dir_path(__FILE__) . 'dist/bundle.css') // Cache busting.
        );
        wp_enqueue_script(
            'my-plugin-admin-scripts',
            plugin_dir_url(__FILE__) . 'dist/bundle.js',
            [],
            filemtime(plugin_dir_path(__FILE__) . 'dist/bundle.js'), // Cache busting.
            true // Load in footer.
        );
    }
}
add_action('admin_enqueue_scripts', 'my_plugin_enqueue_admin_styles');


// -----------------------------------------------------------------------------
// Inject the WebSocket script.
// We will t
// -----------------------------------------------------------------------------

function hot_reload_websocket()
{
    wp_enqueue_script(
        'my-plugin-ws-scripts',
        'http://'
    );

    $inline_ws_content = "
        const ws = new WebSocket('ws://" . PROXY_URL . ":8080');
        ws.onmessage = async (event) => {
            if (event.data === 'reload') {
                console.log('Reloading module...');
                
                // Dynamically import the updated module
                const module = await import('" . MY_PLUGIN_URL . "dist/bundle.js' + '?t=' + new Date().getTime());
                
                const link = document.querySelector(`#my-plugin-admin-styles-css`);
                link.href = link.href.split('?')[0] + '?t=' + new Date().getTime();
            }
        };

        ws.onerror = (error) => console.error('WebSocket error:', error);
    ";

    wp_add_inline_script('my-plugin-ws-scripts', $inline_ws_content);
}

// Function to check if .env file exists and enqueue WebSocket script if it does
if (file_exists(plugin_dir_path(__FILE__) . '.env')) {


    function load_proxy_url()
    {
        $env_path = plugin_dir_path(__FILE__) . '.env';

        if (file_exists($env_path)) {
            // Parse .env file for PROXY_URL
            $env_content = file_get_contents($env_path);
            if (preg_match('/^PROXY_URL\s*=\s*(.+)$/m', $env_content, $matches)) {
                return trim($matches[1]);
            }
        }

        // Return null if .env file or PROXY_URL is missing
        return null;
    }

    // Load env URL
    define('PROXY_URL', load_proxy_url());

    // Add WebSocket script
    add_action('admin_enqueue_scripts', 'hot_reload_websocket');
}





// -----------------------------------------------------------------------------
// End of Inject the WebSocket script.
// -----------------------------------------------------------------------------
