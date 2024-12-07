<?php
/**
 * Plugin Name: Easy Post Comments
 * Description: This plugin is particularly useful for developers who want a highly customizable comment system that adheres to the principles of separation of concerns
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('CUSTOM_COMMENTS_PATH', plugin_dir_path(__FILE__));
define('CUSTOM_COMMENTS_URL', plugin_dir_url(__FILE__));

// Autoload classes
spl_autoload_register(function ($class) {
    $base_dir = CUSTOM_COMMENTS_PATH . 'includes/';
    $file = $base_dir . str_replace('_', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Initialize the plugin
function custom_comments_init() {
    $controller = new Custom_Comments_Controller();
    $controller->init();
}
add_action('plugins_loaded', 'custom_comments_init');
