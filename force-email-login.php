<?php
/*
Plugin Name: Force email login
Author: Takayuki Miyauchi
Plugin URI: http://wpist.me/
Description: Use email address for login to your WordPress.
Version: 0.1.0
Author URI: http://wpist.me/
*/

new Force_Email_Auth();

class Force_Email_Auth {

function __construct()
{
    add_action('plugins_loaded', array(&$this, 'plugins_loaded'));
}

public function plugins_loaded()
{
    if (get_transient('force_email_login_lockdown') && isset($_POST['log'])) {
        wp_die('Please retry after a few seconds.');
    }

    remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);
    add_filter('authenticate', array(&$this, 'authenticate'), 20, 3);
    add_action('wp_login_failed', array(&$this, 'wp_login_failed'));
}

public function wp_login_failed()
{
    $lockdown = intval(apply_filters('force_email_login_lockdown', 10));
    set_transient('force_email_login_lockdown', true, $lockdown);
}

public function authenticate( $user, $username, $password )
{
    if (is_a($user, 'WP_User')) {
        return $user;
    }

    if (!empty($username) && is_email($username)) {
        $user = get_user_by('email', $username);
        if (isset($user, $user->user_login, $user->user_status)) {
            if (0 === intval($user->user_status)) {
                $username = $user->user_login;
                return wp_authenticate_username_password(null, $username, $password);
            }
        }
    }

    if (!empty($username) || !empty($password)) {
        return false;
    } else {
        return wp_authenticate_username_password(null, "", "");
    }
}

}

