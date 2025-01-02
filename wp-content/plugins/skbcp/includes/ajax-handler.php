<?php
// Ensure this file is being included by a parent file
defined('ABSPATH') || exit;

class SKBCP_Ajax_Handler
{
    public function __construct()
    {
        add_action('wp_ajax_check_protected_passcode', array($this, 'check_protected_passcode'));
        add_action('wp_ajax_nopriv_check_protected_passcode', array($this, 'check_protected_passcode'));
    }

    public function check_protected_passcode()
    {
        // Get the passcode from the AJAX request
        $passcode = isset($_POST['passcode']) ? sanitize_text_field($_POST['passcode']) : '';
        error_log('Passcode: ' . $passcode);
        //get code from database when user id is current user id
        global $wpdb;
        $table_name = $wpdb->prefix . 'protected_code';
        $user_id = get_current_user_id();
        $code = $wpdb->get_var($wpdb->prepare("SELECT code FROM $table_name WHERE user_id = %d", $user_id));
        // Check if the passcode matches the code in the database
        if ($passcode === $code) {
            wp_send_json(array('success' => true));
        } else {
            wp_send_json(array('success' => false));
        }
        // Always die in functions echoing AJAX content
        wp_die();
    }
}

// Initialize the class
new SKBCP_Ajax_Handler();
