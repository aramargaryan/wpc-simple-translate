<?php
/**git
 * Plugin Name: WPC Simple Translate
 * Plugin URI:
 * Description: This plugin allows you translate page content, sliders, forms, galleries, page builders widgets...
 * Version: 1.1.9
 * Author: Planet Studio team
 * Author URI: https://planetstudio.am
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

defined('ABSPATH') || die('Access Denied');
define('ET_INT_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('ET_PREFIX', 'et');
define('ET_VERSION', '1.1.9');

add_filter( 'wpcSimpleTranslate', function( $str ){

  $lng_slug = "";

  if ( defined ( 'ICL_LANGUAGE_CODE' )) {
    $lng_slug = ICL_LANGUAGE_CODE;
  } elseif ( function_exists('pll_current_language')) {
    $lng_slug = pll_current_language();
  } else {
    return $str;
  };

  preg_match("/\[\:".$lng_slug."\](.*?)\[\:/i", $str, $out);

  if(is_array($out) && isset($out[1])){
    return $out[1];
  } else {
    return $str;
  }

});


/**
 * Main Class.
 *
 * @class wpcSimpleTranslate
 */
final class wpcSimpleTranslate {
  /**
   * The single instance of the class.
   */
  protected static $_instance = NULL;
  /**
   * Plugin directory path.
   */
  public $plugin_dir = '';


  /**
   * Main wpcSimpleTranslate Instance.
   * Ensures only one instance is loaded or can be loaded.
   *
   * @static
   * @return wpcSimpleTranslate - Main instance.
   */
  public static function instance() {
    if ( is_null(self::$_instance) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
   * wpcSimpleTranslate Constructor.
   */
  public function __construct() {
    $this->plugin_dir = WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__));
    $this->add_actions();
  }

  /**
   * Add actions.
   */


  private function add_actions() {
    add_action('admin_notices', array($this, 'check_mandatory_plugin'));
    add_action('admin_enqueue_scripts', array($this, 'register_scripts_style'));
    add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);
  

    if( !is_admin() ) {
      add_action('init',  array( $this, 'et_init'));
    }
    add_action('admin_init',  array( $this, 'et_admin_init'));
    // Plugin activation.
    register_activation_hook(__FILE__, array($this, 'global_activate'));
  }

  public function et_admin_init() {   

  }

  /**
   * Check plugins which are mandatory for wpcSimpleTranslate work
   * Print message if plugins not exists
  */
  public function check_mandatory_plugin() {
    if ( !defined( 'ICL_LANGUAGE_CODE' ) && !function_exists('pll_current_language') ) {
      $class = 'notice notice-error et-notice';
      $message = __( 'Please install WPML or Polylang plugin to start using WPC Simple Translate plugin.', 'et' );
      printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
  }

  /**
   * Work after plugin activation and is redirect to plugin menu
  */
  public function global_activate() {
    wp_redirect( add_query_arg( array( 'page' => 'wpcSimpleTranslate' ), admin_url( 'admin.php' ) ) );
  }

  /**
   * Register and add menu
  */
  public function addPluginAdminMenu() {
    add_menu_page(  'wpcSimpleTranslate', 'WPC Simple Translate', 'manage_options', 'wpcSimpleTranslate', array( $this, 'displayPluginAdminDashboard' ), 'dashicons-translation' );
  }

  /**
   * Include admin view page
  */
  public function displayPluginAdminDashboard() {
    require_once("admin/view.php");
  }

  /**
   * Main function which change page content related to the language
  */
  public function et_init() {

    function callback( $buffer ) {

      $buffer =   str_replace("\n", "-wpc-break-line-", $buffer);
    
    
      $out = preg_replace_callback("/\[:(.*?)\[:]/", function($part){

        if ( defined ( 'ICL_LANGUAGE_CODE' )) {
          $lng_slug = ICL_LANGUAGE_CODE;
        } elseif ( function_exists('pll_current_language')) {
          $lng_slug = pll_current_language();
        } else {
          return $part;
        }

        preg_match("/\[\:".$lng_slug."\](.*?)\[\:/is", $part[0], $out);

    if(is_array($out) && isset($out[1])){
      return $out[1];
    } else {
      return $part[0];
    }

      }, $buffer);

      $out =   str_replace("-wpc-break-line-", "\n", $out);

      return $out;

    }
    ob_start("callback");

  }

  /**
   * Register styles and scripts.
   */
  public function register_scripts_style() {
	wp_print_scripts('jquery');
	wp_register_script('easy-translate', plugins_url(plugin_basename(dirname(__FILE__))) . '/script/admin.js', FALSE, ET_VERSION);
    wp_enqueue_script('easy-translate');
    wp_register_style('easy-translate', plugins_url(plugin_basename(dirname(__FILE__))) . '/style/admin.css', FALSE, ET_VERSION);
    wp_enqueue_style('easy-translate');
  }
	
}

// deactivate popup
add_action('admin_footer', 'et_deactivate_popup');
function et_deactivate_popup(){
   require_once('includes/et-deactivate-popup.php');
}

/**
 * Main instance of wpcSimpleTranslate.
 *
 * @return wpcSimpleTranslate The main instance to prevent the need to use globals.
 */
function wpcSimpleTranslate() {
  return wpcSimpleTranslate::instance();
}
wpcSimpleTranslate();
