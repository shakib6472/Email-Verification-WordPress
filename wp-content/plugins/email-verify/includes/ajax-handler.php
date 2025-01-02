<?php
class Email_Verify_Ajax_Handler
{

    public function __construct()
    {
        add_action('wp_ajax_skb_resend_email', array($this, 'skb_resend_email'));
        add_action('wp_ajax_nopriv_skb_resend_email', array($this, 'skb_resend_email'));
        add_action('wp_ajax_skb_verify_email', array($this, 'skb_verify_email'));
        add_action('wp_ajax_nopriv_skb_verify_email', array($this, 'skb_verify_email'));
    }

    public function skb_resend_email()
    {
        $user_id = get_current_user_id();
        $email = wp_get_current_user()->user_email;

        if (empty($email) || !is_email($email)) {
            wp_send_json_error(array('message' => 'Invalid email address'));
            return;
        }
        $verification_code = get_user_meta(get_current_user_id(), 'email_verification_code', true);
        if (empty($verification_code)) {
            $verification_code = rand(100000, 999999);
            update_user_meta($user_id, 'email_verification_code', $verification_code);
            update_user_meta($user_id, 'email_verified', 0);
        }

        $subject = 'Email Verification';
        $message = '<html><body>';
        $message .= '<h1>Email Verification</h1>';
        $message .= '<p> Here is Your Code Again. Please verify your email by Putting the Code :</p>';
        $message .= '<p>' . $verification_code . '</p>';
        $message .= '<p>If you did not register, please ignore this email.</p>';
        $message .= '</body></html>';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $mailsent = wp_mail($email, $subject, $message, $headers);

        if ($mailsent) {
            error_log('Email rensent successfully');
            wp_send_json_success(array('message' => 'Email has been resend successfully.'));
        } else {
            error_log('Failed to resend email');
            wp_send_json_error(array('message' => 'Failed to resend email. Please try again.'));
        }
    }

    public function skb_verify_email()
    {
        $passcode = $_POST['passcode'];
        $verification_code = get_user_meta(get_current_user_id(), 'email_verification_code', true);
        if ($passcode == $verification_code) {
            update_user_meta(get_current_user_id(), 'email_verified', 1);
            wp_send_json_success(array('message' => 'Email has been verified successfully.'));
        } else {
            wp_send_json_error(array('message' => 'Code is incorrect. Please try again.'));
        }
    }
}

new Email_Verify_Ajax_Handler();
