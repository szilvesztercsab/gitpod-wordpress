<?php
/**
 * Plugin Name: Mailhog for WordPress
 * Description: This plugin routes your emails to MailHog for development purpose.
 * Plugin URI: https://github.com/szilvesztercsab/gitpod-wordpress
 * Author: Csaba Szilveszter-Berei
 * Author URI: https://github.com/szilvesztercsab/gitpod-wordpress
 * Version: 1.0.2
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) || exit;

/**
 * WP MailHog
 */
class WP_MailHog {

    function __construct() {
        $this->define_constants();
        $this->init_phpmailer();
    }

    /**
     * Define constants
     *
     * @return void
     */
    public function define_constants() {

        if ( ! defined( 'WP_MAILHOG_HOST') ) {
            define( 'WP_MAILHOG_HOST', 'mailhog' );
        }

        if ( ! defined( 'WP_MAILHOG_PORT') ) {
            define( 'WP_MAILHOG_PORT', 1025 );
        }
    }

    /**
     * Override the PHPMailer SMTP options
     *
     * @return void
     */
    public function init_phpmailer() {
      add_action( 'phpmailer_init', function ( $php_mailer ) {
        $php_mailer->Host     = 'mailhog';
        $php_mailer->Port     = 1025;
        $php_mailer->From     = 'wordpress@localhost.test';
        $php_mailer->FromName = 'WordPress';
        $php_mailer->IsSMTP();
      }, 10 );

      add_filter( 'wp_mail_from', fn( $email ) => 'wordpress@localhost.test' );

      add_filter( 'wp_mail_from_name', fn( $name ) => 'localhost' );
    }
}

new WP_MailHog();
