<?php
defined('ABSPATH') or die('');

function easy_voice_mail_public()
{
  $output = "";
  $js_url = plugins_url('/js/easy-voice-mail.js', __FILE__);
  $css_url = plugins_url('/css/easy-voice-mail.css', __FILE__);
  $script_version = false; 
  $css_version = null;
  $in_footer = false;
  $media = 'all';
  wp_enqueue_script('js_handle_voice_mail', $js_url, array(), $script_version, $in_footer);
  wp_enqueue_style('css_handle_voice_mail', $css_url, array(), $css_version, $media);
  $output = "<div id='easy-voice-mail'>";
  if (get_option('easy_voice_mail_show_description', true)) {
    $output.= "<p>".esc_html(get_option('easy_voice_mail_description', 'Press the button to start recording (Please state your name and phone)'))."</p>";
  }
  $duration = esc_html(get_option('easy_voice_mail_max_duration_minutes', 2) * 60 +
    get_option('easy_voice_mail_max_duration_seconds', 0));
  $output.="<input id='easy_voice_mail_max_duration' type='hidden' value='$duration' />";
  $output.="<form id='easy-voice-mail-form' action='".str_replace('%7E', '~', esc_url($_SERVER['REQUEST_URI']))."' method='post'>"
  ."<input type='hidden' name='easy_voice_mail_message'/>"
  ."<input type='hidden' id='question-input' name='question-input'/>"
  ."</form>";
  global $wpdb;
  $table_name = $wpdb->prefix . 'easy_voice_mail';
  if (isset($_POST) && isset($_POST['easy_voice_mail_message']) && !empty($_POST['easy_voice_mail_message'])) {
    if ($wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") != $table_name) {
      $sql  = "CREATE TABLE $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
              message VARCHAR(2000000),
              PRIMARY KEY  (id)
              );";
              if (!function_exists('dbDelta')) {
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
              }
              dbDelta($sql);
            }
            $wpdb->insert(
              $table_name,
              array(
                'time' => current_time('mysql'),
                'message' => sanitize_text_field($_POST['easy_voice_mail_message'])
              )
            );

            //Add Answer
            $new_answer = array(
              'post_title'    => 'Kypseli',
              'post_status'   => 'publish',
              'post_type' => 'answer',
            );
            $new_answer_id = wp_insert_post( $new_answer );
            echo  $new_answer_id ;
            wp_set_object_terms( $new_answer_id , array('audio'), 'type');
            if(!empty($_POST['question-input'])){
              add_post_meta( $new_answer_id , 'question', $_POST['question-input'], true);
            }
            add_post_meta( $new_answer_id , 'audio_webm',  sanitize_text_field($_POST['easy_voice_mail_message']), true);
            //Email
            if(get_option('easy_voice_mail_notify_by_email', false)){
              $emailAdress = get_option('easy_voice_mail_notification_email', 'contact@phoenix-dz.com');
              if(is_email($emailAdress) && strcmp($emailAdress, 'contact@phoenix-dz.com')!=0 ){
               $emailheaders = array('Content-Type: text/html; charset=UTF-8');
               wp_mail( $emailAdress, 'Easy Voice Mail - New Voice Message', 'Hello, You have a new message in your Wordpress webSite. To access the messages, login as admin and go to Tools -> Easy Voice Mail', $emailheaders);
             }
           }
         }
         $output.="<div class='easy-voice-mail-controls'>"
         ."<button id='easy_voice_mail_record' style='display: none;'>Record</button>"
         ."<button id='easy_voice_mail_stop' style='display: none;'>Stop</button>"
         ."<button id='easy_voice_mail_play' style='display: none;'>Play</button>"
         ."<button id='easy_voice_mail_pause' style='display: none;'>Pause</button>"
         ."<button id='easy_voice_mail_save' style='display: none;'>Save</button>"
         ."<button id='easy_voice_mail_cancel' style='display: none;'>Cancel</button>"
         ."</div>";
         if (get_option('easy_voice_mail_show_countdown', true)) {
          $output.="<p id='easy_voice_mail_countdown'>0<p>";
        }
        $output.="</div>";
        return $output;
      }

