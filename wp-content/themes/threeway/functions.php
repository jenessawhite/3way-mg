<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

// Include custom navwalker
require_once('bs4navwalker.php');

// Register WordPress nav menu
register_nav_menu('main', 'Main Nav');

if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
    'page_title' 	=> 'Site Settings',
    'menu_title'	=> 'Site Settings',
    'menu_slug' 	=> 'site-settings',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
  ));
}

function auto_copyright($year = 'auto'){
  if(intval($year) == 'auto'){ $year = date('Y'); }
  if(intval($year) == date('Y')){ echo intval($year); }
  if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
  if(intval($year) > date('Y')){ echo date('Y'); }
}

function themeslug_setup(){
  /**
   * Add theme support for the Eventbrite API plugin.
   * See: https://wordpress.org/plugins/eventbrite-api/
   */
  add_theme_support( 'eventbrite' );
}
add_action( 'after_setup_theme', 'themeslug_setup' );
