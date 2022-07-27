<?php
/**
 * Plugin Name:       Easy Voice Mail
 * Plugin URI:        https://www.phoenix-dz.com/easy-voice-mail.html
 * Description:       Provide an accessible simple and efficient way for your client to contact you and express their needs.
 * Version:           1.2.3
 * Requires at least: 3.8
 * Requires PHP:      5.3.3
 * Author:            Phoenix Studio
 * Author URI:        https://www.phoenix-dz.com/
 * License:           GPL2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       easy-voice-mail
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or die( '' );
define( 'EASY_VOICE_MAIL_VERSION', '1.2.3' );

if ( is_admin() ) {
    require_once __DIR__ . '/admin/easy-voice-mail-admin.php';
}
else{
  require_once __DIR__ . '/public/easy-voice-mail-public.php';
  add_shortcode('easy_voice_mail', 'easy_voice_mail_public'); 
}



function easy_voice_mail_activation_function(){
  add_option('easy_voice_mail_description', 'Press the button to start recording (Please state your name and phone)');
  add_option('easy_voice_mail_show_description', true);
  add_option('easy_voice_mail_max_duration_minutes', 2);
  add_option('easy_voice_mail_max_duration_seconds', 0);
  add_option('easy_voice_mail_show_countdown', true);
  add_option('easy_voice_mail_notify_by_email', false);
  add_option('easy_voice_mail_notification_email', 'contact@phoenix-dz.com');
}

function easy_voice_mail_deactivation_function(){
  delete_option('easy_voice_mail_description');
  delete_option('easy_voice_mail_show_description');
  delete_option('easy_voice_mail_max_duration_minutes');
  delete_option('easy_voice_mail_max_duration_seconds');
  delete_option('easy_voice_mail_show_countdown');
  add_option('easy_voice_mail_notify_by_email');
  add_option('easy_voice_mail_notification_email');
}

function easy_voice_mail_uninstall_function(){
  global $wpdb;
  $table_name = $wpdb->prefix . 'easy_voice_mail';
  $wpdb->query( "DROP TABLE IF EXISTS $table_name");  
}

register_activation_hook(__FILE__,'easy_voice_mail_activation_function');
register_deactivation_hook(__FILE__, 'easy_voice_mail_deactivation_function');
register_uninstall_hook(__FILE__, 'easy_voice_mail_uninstall_function');




function easy_voice_mail_load_plugin_textdomain() {
  load_plugin_textdomain( 'easy_voice_mail', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'easy_voice_mail_load_plugin_textdomain' );
