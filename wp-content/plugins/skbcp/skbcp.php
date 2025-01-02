<?php

/*
 * Plugin Name:      Content Protection
* Plugin URI:        https://github.com/shakib6472/
* Description:       This plugin will help you to protect your content from being copied.
* Version:           1.0.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Shakib Shown
* Author URI:        https://github.com/shakib6472/
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       core-helper
* Domain Path:       /languages
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define SKBCP_PLUGIN_dir & uri.
define('SKBCP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SKBCP_PLUGIN_URI', plugin_dir_url(__FILE__));

// Include the main class file.
require_once SKBCP_PLUGIN_DIR . 'includes/class-skbcp.php';
//ajax handler
require_once SKBCP_PLUGIN_DIR . 'includes/ajax-handler.php';

new SKBCP();

function skbcp_activate()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'protected_code';

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id mediumint(9) NOT NULL,
        code varchar(255) NOT NULL,
        creation_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(__FILE__, 'skbcp_activate');
