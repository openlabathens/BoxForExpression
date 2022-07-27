<?php
function easy_voice_mail_admin_menu()
{
  add_management_page('Easy Voice Mail', 'Easy Voice Mail', 'manage_options', __FILE__, 'easy_voice_mail_admin', null);
}

add_action('admin_menu', 'easy_voice_mail_admin_menu');

function easy_voice_mail_admin()
{
  $js_url = plugins_url('/js/easy-voice-mail.js', __FILE__);
  $css_url = plugins_url('/css/easy-voice-mail.css', __FILE__);
  $script_version = false;
  $css_version = null;
  $in_footer = false;
  $media = 'all';
  wp_enqueue_script('js_handle_voice_mail', $js_url, array(), $script_version, $in_footer);
  wp_enqueue_style('css_handle_voice_mail', $css_url, array(), $css_version, $media);
  $default_description = 'Press the button to start recording (Please state your name and phone)';
  $default_show_description = true;
  $default_show_countdown = true;
  $default_max_duration_minutes = 2;
  $default_max_duration_seconds = 0;
  $default_notify_by_email = false;
  $default_notification_email = 'contact@phoenix-dz.com';
  /*
  add_option('easy_voice_mail_notify_by_email', false);
  add_option('easy_voice_mail_notification_email', 'contact@phoenix-dz.com');
  */
  $description = esc_html(get_option('easy_voice_mail_description', $default_description));
  $show_description = esc_html(get_option('easy_voice_mail_show_description', $default_description));
  $max_duration_minutes =esc_html(get_option('easy_voice_mail_max_duration_minutes', $default_max_duration_minutes));
  $max_duration_seconds = esc_html(get_option('easy_voice_mail_max_duration_seconds', $default_max_duration_seconds));
  $show_countdown = esc_html(get_option('easy_voice_mail_show_countdown', $default_show_countdown));
  $notify_by_email = esc_html(get_option('easy_voice_mail_notify_by_email', $default_notify_by_email));
  $notification_email = esc_html(get_option('easy_voice_mail_notification_email', $default_notification_email));
  
  if (isset($_POST['easy_voice_mail_change-clicked'])) {
    update_option('easy_voice_mail_description', sanitize_text_field($_POST['easy_voice_mail_description']));
    if(isset($_POST['easy_voice_mail_showdescription']) && sanitize_text_field($_POST['easy_voice_mail_showdescription'])) {
      update_option('easy_voice_mail_show_description', true);
    }
    else {
      update_option('easy_voice_mail_show_description', false);
    }
    if(isset($_POST['easy_voice_mail_showcountdown']) && sanitize_text_field($_POST['easy_voice_mail_showcountdown'])) {
      update_option('easy_voice_mail_show_countdown', true);
    }
    else {
      update_option('easy_voice_mail_show_countdown', false);
    }
    if(is_numeric(sanitize_key($_POST['easy_voice_mail_maxdurationminutes']))){
      update_option('easy_voice_mail_max_duration_minutes', max(0, min(5, sanitize_key($_POST['easy_voice_mail_maxdurationminutes']))));
    }
    if(is_numeric(sanitize_key($_POST['easy_voice_mail_maxdurationseconds']))){
      update_option('easy_voice_mail_max_duration_seconds', max(0, min(59, sanitize_key($_POST['easy_voice_mail_maxdurationseconds']))));
    }

    if(isset($_POST['easy_voice_mail_notify_by_email']) && sanitize_text_field($_POST['easy_voice_mail_notify_by_email'])) {
      update_option('easy_voice_mail_notify_by_email', true);
    }
    else {
      update_option('easy_voice_mail_notify_by_email', false);
    }
    if(isset($_POST['easy_voice_mail_notification_email']) && is_email($_POST['easy_voice_mail_notification_email'])){
      update_option('easy_voice_mail_notification_email', sanitize_text_field($_POST['easy_voice_mail_notification_email']));
    }
    $description = esc_html(get_option('easy_voice_mail_description', $default_description));
    $show_description = esc_html(get_option('easy_voice_mail_show_description', $default_show_description));
    $max_duration_minutes = esc_html(get_option('easy_voice_mail_max_duration_minutes', $default_max_duration_minutes));
    $max_duration_seconds = esc_html(get_option('easy_voice_mail_max_duration_seconds', $default_max_duration_seconds));
    $show_countdown = esc_html(get_option('easy_voice_mail_show_countdown', $default_show_countdown));
    $notify_by_email = esc_html(get_option('easy_voice_mail_notify_by_email', $default_notify_by_email));
    // check if valid email !
    $notification_email = esc_html(get_option('easy_voice_mail_notification_email', $default_notification_email));
  }
  if (isset($_POST['easy_voice_mail_delete_all_recordings'])) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'easy_voice_mail';
    if ($wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") == $table_name) {
      $sql  = "TRUNCATE TABLE " . $table_name;
      if (!function_exists('dbDelta')) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      }
      $res = $wpdb->query($sql);
    }
  }
  if (isset($_POST['easy_voice_mail_delete_recording_item'])) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'easy_voice_mail';
    if ($wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") == $table_name) {
      $sql  = "DELETE FROM " . $table_name . " WHERE id = " . sanitize_key($_POST['easy_voice_mail_delete_recording_item']);
      if (!function_exists('dbDelta')) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      }
      $res = $wpdb->query($sql);
    }
  }
?>

  <div class="easy-voice-mail-admin-wrap">
    <div class="easy-voice-mail-config">
      <h1 class="wp-heading-inline"><?php _e('Easy Voice Mail Configuration', 'easy-voice-mail'); ?></h1>
      <form action="<?php echo esc_url(str_replace('%7E', '~', $_SERVER['REQUEST_URI'])); ?>" method="post">
        <span>Show this message for users </span>
        <input type="checkbox" name='easy_voice_mail_showdescription' <?php if ($show_description == true) echo 'checked' ?> />
        <br />
        <textarea name="easy_voice_mail_description" placeholder="type description here" rows="2"><?php echo $description; ?></textarea>
        <br />
        <span>Show Countdown</span>
        <input type="checkbox" name='easy_voice_mail_showcountdown' <?php if ($show_countdown == true) echo 'checked' ?> />
        <br />
        Max duration : 
        <input type="number" name="easy_voice_mail_maxdurationminutes" min="0" max="59" value=<?php echo $max_duration_minutes; ?> style="width: 4em;" /> 
        Minutes and
        <input type="number" name="easy_voice_mail_maxdurationseconds" min="0" max="59" value=<?php echo $max_duration_seconds; ?> style="width: 4em;" />
        seconds
        <br />
        <span>Notify me when I reacieve a message</span>
        <input type="checkbox" name='easy_voice_mail_notify_by_email' <?php if ($notify_by_email == true) echo 'checked' ?> />
        <br />
        <span>Notification Email:</span>
        <input type="email" name='easy_voice_mail_notification_email' value="<?php echo  $notification_email?>" />
        <br />
        <input name="easy_voice_mail_change-clicked" type="hidden" value="1" />
        <input type="submit" class="button action" value="Save" />
      </form>
      <form action="<?php echo esc_url(str_replace('%7E', '~', $_SERVER['REQUEST_URI'])); ?>" method="post">
        <input type="hidden" name='easy_voice_mail_delete_all_recordings' value="true" />
        <input type="submit" class="button action" style="background: #ca4a1f;color: whitesmoke;border-color: #ca4a1f;" value="Delete All recordings" onclick="eacyVoiceMailDeleteConfirmation(event)" />
      </form>
    </div>
    <?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'easy_voice_mail';
    if ($wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") == $table_name) {
      $results = $wpdb->get_results("SELECT message, time, id FROM " . $table_name);
    ?>
      <div class="easy-voice-mail-audio-items">
        <?php
        if (is_array($results) && count($results) > 0) {
          $results = array_reverse($results);
          foreach ($results as $element) :
        ?>
            <div class="easy-voice-mail-audio-item">
              <audio src="<?php echo esc_html($element->message) ?>" controls>
                your browser does not support audio
              </audio>
              <a download="<?php echo esc_html($element->id) ?>.webm" href='<?php echo esc_html($element->message)?>'>Download</a>
              <p><?php echo esc_html($element->time) ?></p>
              <form action="<?php echo esc_url(str_replace('%7E', '~', $_SERVER['REQUEST_URI'])); ?>" method="post">
                <input type="hidden" name='easy_voice_mail_delete_recording_item' value="<?php echo esc_html($element->id) ?>" />
                <input type="submit" class="button action" value="Delete" />
              </form>
            </div>
          <?php
          endforeach;
          ?>
      </div>
  <?php
        }
    }
  ?>
  </div>
  <?php
}
