<?php

/**
 * Plugin Setup Page
 *
 * This page displays the setup options for prodigrow plugin.
 */

// Security check (replace with prodigrow plugin's main file slug)
// if ( ! defined( 'prodigrow_PLUGIN_SLUG' ) ) {
//   exit;
// }

?>

<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

<p>Welcome to the setup page for prodigrow plugin!</p>

<form method="post" action="options.php">
  <?php settings_fields( 'prodigrow_plugin_settings_group' ); // Replace with prodigrow settings group name ?>
  <?php do_settings_sections( 'prodigrow_plugin_settings_section' ); // Replace with prodigrow settings section name ?>
  <p><input type="submit" class="button button-primary" value="Save Changes"></p>
</form>


<?
