<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class SKB_Email_Verify
{

    public function __construct()
    {
        add_action('user_register', array($this, 'send_verification_email'));
        add_action('template_redirect', array($this, 'check_email_verification'));
    }

    public static function activate()
    {
        // Activation code here
    }

    public static function deactivate()
    {
        // Deactivation code here
    }

    public function send_verification_email($user_id)
    {
        $user = get_userdata($user_id);
        $email = $user->user_email;
        $verification_code = rand(100000, 999999);
        update_user_meta($user_id, 'email_verification_code', $verification_code);
        update_user_meta($user_id, 'email_verified', 0);
 
        $subject = 'Email Verification';
        $message = '<html><body>';
        $message .= '<h1>Email Verification</h1>';
        $message .= '<p>Thank you for registering. Please verify your email by Putting the Code :</p>';
        $message .= '<p>' . $verification_code . '</p>';
        $message .= '<p>If you did not register, please ignore this email.</p>';
        $message .= '</body></html>'; 
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $mailsent = wp_mail($email, $subject, $message, $headers);

        if ($mailsent) {
           error_log('Email sent successfully');
        } else {
            error_log('Failed to send email');
        }

    }

    public function check_email_verification()
    {
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $email_verified = get_user_meta($user_id, 'email_verified', true);

            if (!$email_verified) {
                wp_head(); 
                include plugin_dir_path(__FILE__) . 'verify.php';
                wp_footer();
                exit;
            }
        }

        if (isset($_GET['verify_email'])) {
            $verification_code = sanitize_text_field($_GET['verify_email']);
            $user_query = new WP_User_Query(array(
                'meta_key' => 'email_verification_code',
                'meta_value' => $verification_code,
                'number' => 1,
                'count_total' => false,
                'fields' => 'ID'
            ));

            if (!empty($user_query->results)) {
                $user_id = $user_query->results[0];
                update_user_meta($user_id, 'email_verified', 1);
                delete_user_meta($user_id, 'email_verification_code');
                wp_redirect(home_url());
                exit;
            }
        }
    }
}

register_activation_hook(__FILE__, array('SKB_Email_Verify', 'activate'));
register_deactivation_hook(__FILE__, array('SKB_Email_Verify', 'deactivate'));

new SKB_Email_Verify();
