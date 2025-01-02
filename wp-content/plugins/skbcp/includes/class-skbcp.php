<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class SKBCP
{
    public function __construct()
    {
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('init', array($this, 'init'));
        add_action('template_redirect', array($this, 'protect_page'));
        add_action('user_register', array($this, 'send_mail'));
    }

    public function init()
    {
        // Actions to perform on initialization, if any.
    }

    // Add Admin menu page
    public function add_admin_menu()
    {
        add_menu_page(
            'Content Protection',
            'Content Protection',
            'manage_options',
            'content-protection',
            array($this, 'admin_page'),
            'dashicons-lock',
            6
        );
    }

    // Admin page - set the page to protection
    public function admin_page()
    {
        $protected_pages = get_option('protected_pages', array());
        error_log(print_r($protected_pages, true));
        // Header then get all pages, with multiple selectable options. Select & save 
        // the page to protect.
?>
        <h1>Content Protection</h1>
        <form method="post">
            <label for="pages">Select pages to protect:</label>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pages'])) {
                update_option('protected_pages', $_POST['pages']);
            }

            $protected_pages = get_option('protected_pages', array());
            $pages = get_pages();
            foreach ($pages as $page) {
                $checked = in_array($page->ID, $protected_pages) ? 'checked' : '';
            ?>
                <div>
                    <input type="checkbox" name="pages[]" value=" <?php echo $page->ID; ?>" <?php echo $checked; ?> id="page-<?php echo $page->ID; ?>">
                    <label for="page-<?php echo $page->ID; ?>"><?php echo  $page->post_title ?> </label>
                </div>
            <?php
            }
            ?>
            <input type="submit" value="Protect">
        </form>
<?php

    }

    public function deactivate()
    {
        update_option('protected_pages', array());
        global $wpdb;
        $table_name = $wpdb->prefix . 'protected_code';
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
    }

    //function protect the page
    public function protect_page()
    {
        // get options $protected_pages = get_option('protected_pages', array());
        // if current page is in $protected_pages, show the instead of page content jusy have the header & footer & include my template file pro-design.php
        // else show the page content 
        $protected_pages = get_option('protected_pages', array());
        if (in_array(get_the_ID(), $protected_pages)) {
            $is_unlocked = false;
            if (isset($_COOKIE['protected_passcode'])) {
                global $wpdb;
                $table_name = $wpdb->prefix . 'protected_code';
                $user_id = get_current_user_id();
                $code = $wpdb->get_var($wpdb->prepare("SELECT code FROM $table_name WHERE user_id = %d", $user_id));
                if ($_COOKIE['protected_passcode'] === $code) {
                    $is_unlocked = true;
                }
            }
            if (!$is_unlocked) {
                wp_head();
                require SKBCP_PLUGIN_DIR . 'includes/pro-design.php';
                wp_footer();
                exit;
            }
        }
    } 
    //send a mail when register a new user with 6 digit passcode & store this passcode in the database
    public function send_mail($user_id)
    {
        $passcode = rand(100000, 999999);
        global $wpdb;
        $table_name = $wpdb->prefix . 'protected_code';
        $wpdb->insert(
            $table_name,
            array(
                'user_id' => $user_id,
                'code' => $passcode
            )
        );

        $to = get_userdata($user_id)->user_email;
        $subject = 'Your Passcode for Content Protection';
        $message = '
        <html>
        <head>
            <title>Your Passcode</title>
        </head>
        <body>
            <h2>Welcome to Our Website!</h2>
            <p>Thank you for registering. Your passcode for accessing protected content is:</p>
            <h3 style="color: blue;">' . $passcode . '</h3>
            <p>Please keep this passcode secure and do not share it with anyone.</p>
            <p>Best regards,<br><a href="https://github.com/shakib6472">Shakib Shown</a></p>
        </body>
        </html>
        ';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $message, $headers);
        error_log('Mail sent to ' . $to);
    }
}
