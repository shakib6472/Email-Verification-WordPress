<?php 
/*
 * Plugin Name:      Email Verification
* Plugin URI:        https://github.com/shakib6472/
* Description:       This plugin will help you to verify email after registration.
* Version:           1.0.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Shakib Shown
* Author URI:        https://github.com/shakib6472/
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       skb-email-verify
* Domain Path:       /languages
*/
if (!defined('ABSPATH')) {
exit; // Exit if accessed directly.
}
// Define the plugin path using a predefined WordPress function.
define('SKBEV_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SKBEV_PLUGIN_URI', plugin_dir_url(__FILE__));

// Include the main class file.
require_once SKBEV_PLUGIN_DIR . 'includes/class-skb-email-verify.php';
//ajax handler
require_once SKBEV_PLUGIN_DIR . 'includes/ajax-handler.php';