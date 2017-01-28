<?php
/*
Plugin Name: Force Email Login
Author: Takayuki Miyauchi
Plugin URI: https://github.com/miya0001/force-email-login
Description: Use email address for login to your WordPress.
Version: 0.6.0
Author URI: https://miya.io/
*/

$force_email_auth = new Force_Email_Auth();
$force_email_auth->register();


class Force_Email_Auth {

	function register()
	{
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	public function plugins_loaded()
	{
		remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
		add_filter( 'authenticate', array( $this, 'authenticate'), 20, 3 );
	}

	public function authenticate( $user, $username, $password )
	{
		if ( is_a( $user, 'WP_User' ) ) {
			return $user;
		}

		if ( ! empty( $username ) && is_email( $username ) ) {
			$user = get_user_by( 'email', $username );
			if ( isset( $user, $user->user_login, $user->user_status ) ) {
				if ( 0 === intval( $user->user_status ) ) {
					$username = $user->user_login;
					return wp_authenticate_username_password( null, $username, $password );
				}
			}
		}

		if ( ! empty( $username ) || ! empty( $password ) ) {
			return false;
		} else {
			return wp_authenticate_username_password( null, "", "" );
		}
	}
}
