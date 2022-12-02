<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://tirony.me
 * @since      1.0.0
 *
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/includes
 * @author     t.i.rony <touhidul747@gmail.com>
 */
class Compustore_Stores
{

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      Compustore_Stores_Loader $loader Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string $plugin_name The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The current version of the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string $version The current version of the plugin.
   */
  protected $version;

  /**
   * Define the core functionality of the plugin.
   *
   * Set the plugin name and the plugin version that can be used throughout the plugin.
   * Load the dependencies, define the locale, and set the hooks for the admin area and
   * the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function __construct()
  {
    if ( defined('COMPUSTORE_STORES_VERSION') ) {
      $this -> version = COMPUSTORE_STORES_VERSION;
    } else {
      $this -> version = '1.0.0';
    }
    if ( defined('COMPUSTORE_STORES_PLUGINNAME') ) {
      $this -> plugin_name = COMPUSTORE_STORES_PLUGINNAME;
    } else {
      $this -> plugin_name = 'compustore-stores';
    }
    $this -> load_dependencies();
    $this -> set_locale();
    $this -> define_admin_hooks();
    $this -> define_public_hooks();

  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - Compustore_Stores_Loader. Orchestrates the hooks of the plugin.
   * - Compustore_Stores_i18n. Defines internationalization functionality.
   * - Compustore_Stores_Admin. Defines all hooks for the admin area.
   * - Compustore_Stores_Public. Defines all hooks for the public side of the site.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies()
  {

    /**
     * The class responsible for orchestrating the actions and filters of the
     * core plugin.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-compustore-stores-loader.php';
    /**
     * The class responsible for defining internationalization functionality
     * of the plugin.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-compustore-stores-i18n.php';
    /**
     * The class responsible for defining all actions that occur in the admin area.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-compustore-stores-admin.php';
    /**
     * The class responsible for defining all actions that occur in the public-facing
     * side of the site.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-compustore-stores-public.php';
    /**
     * TGM plugin activation
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/others/class-tgm-plugin-activation.php';


    $this -> loader = new Compustore_Stores_Loader();

  }

  /**
   * Define the locale for this plugin for internationalization.
   *
   * Uses the Compustore_Stores_i18n class in order to set the domain and to register the hook
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function set_locale()
  {

    $plugin_i18n = new Compustore_Stores_i18n();
    $this -> loader -> add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

  }

  /**
   * Register all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_admin_hooks()
  {

    $plugin_admin = new Compustore_Stores_Admin($this -> get_plugin_name(), $this -> get_version());
    $this -> loader -> add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
    $this -> loader -> add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    $this -> loader -> add_action('tgmpa_register', $plugin_admin, 'compustore_stores_register_required_plugins');
    $this -> loader -> add_action('wp_ajax_compu_stores_ajax_callback', $plugin_admin, 'compu_stores_ajax_callback');
    $this -> loader -> add_action('init', $plugin_admin, 'compu_load_all_acf_fields');


  }

  /**
   * Register all of the hooks related to the public-facing functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_public_hooks()
  {

    $plugin_public = new Compustore_Stores_Public($this -> get_plugin_name(), $this -> get_version());
    $this -> loader -> add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
    $this -> loader -> add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    $this -> loader -> add_action('init', $plugin_public, 'create_store_cpt');
    $this -> loader -> add_action('wp_ajax_nopriv_compu_stores_ajax_callback', $plugin_public, 'compu_stores_ajax_callback');
  }

  /**
   * Run the loader to execute all of the hooks with WordPress.
   *
   * @since    1.0.0
   */
  public function run()
  {
    $this -> loader -> run();
  }

  /**
   * The name of the plugin used to uniquely identify it within the context of
   * WordPress and to define internationalization functionality.
   *
   * @return    string    The name of the plugin.
   * @since     1.0.0
   */
  public function get_plugin_name()
  {
    return $this -> plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @return    Compustore_Stores_Loader    Orchestrates the hooks of the plugin.
   * @since     1.0.0
   */
  public function get_loader()
  {
    return $this -> loader;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @return    string    The version number of the plugin.
   * @since     1.0.0
   */
  public function get_version()
  {
    return $this -> version;
  }

}
