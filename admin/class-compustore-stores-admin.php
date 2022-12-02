<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://tirony.me
 * @since      1.0.0
 *
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/admin
 * @author     t.i.rony <touhidul747@gmail.com>
 */
class Compustore_Stores_Admin
{

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string $plugin_name The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string $version The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @param string $plugin_name The name of this plugin.
   * @param string $version The version of this plugin.
   * @since    1.0.0
   */
  public function __construct($plugin_name, $version)
  {

    $this -> plugin_name = $plugin_name;
    $this -> version     = $version;

  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_styles()
  {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Compustore_Stores_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Compustore_Stores_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */
    wp_enqueue_style($this -> plugin_name, plugin_dir_url(__FILE__) . 'css/compustore-stores-admin.css', array(), $this -> version, 'all');

  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts()
  {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Compustore_Stores_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Compustore_Stores_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */
    wp_enqueue_script('main-js', plugin_dir_url(__FILE__) . 'js/compustore-stores-admin.js', array('jquery'), $this -> version, false);

    $action      = 'compu_nonce_action';
    $compu_nonce = wp_create_nonce($action);
    wp_localize_script('main-js', 'compu_map_data', ['ajax_url' => admin_url('admin-ajax.php'), 'compustore_nonce' => $compu_nonce, 'plugin_img_dir' => plugin_dir_url(__FILE__) . '/images/',]);

  }

  // Checks if Advanced custom fields plugin is active
  public function compustore_stores_register_required_plugins()
  {

    $plugins = array(
      array(
        'name'             => 'Advanced Custom Fields',
        'slug'             => 'advanced-custom-fields',
        'required'         => true,
        'force_activation' => true,
      )
    );
    $config  = array(
      'id'           => 'compustore-stores',                 // Unique ID for hashing notices for multiple instances of TGMPA.
      'default_path' => '',                      // Default absolute path to bundled plugins.
      'menu'         => 'tgmpa-install-plugins', // Menu slug.
      'parent_slug'  => 'plugins.php',            // Parent menu slug.
      'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
      'has_notices'  => true,                    // Show admin notices or not.
      'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
      'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
      'is_automatic' => false,                   // Automatically activate plugins after installation or not.
      'message'      => '',);
    tgmpa($plugins, $config);
  }

  //////////////// ACF Fields //////////////////
  public function compu_load_all_acf_fields()
  {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array(
        'key' => 'group_6386dd128da38',
        'title' => 'Store Settings',
        'fields' => array(
          array(
            'key' => 'field_6386dd125f413',
            'label' => 'Phone',
            'name' => 'compu_phone',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386dd895f418',
            'label' => 'Email',
            'name' => 'compu_email',
            'aria-label' => '',
            'type' => 'email',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386e27d63530',
            'label' => 'Latitude',
            'name' => 'compu_latitude',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386e28963531',
            'label' => 'Longitude',
            'name' => 'compu_longitude',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386dd335f414',
            'label' => 'Street',
            'name' => 'compu_street',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386dd515f415',
            'label' => 'Postal Code',
            'name' => 'compu_postal_code',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386dd615f416',
            'label' => 'City',
            'name' => 'compu_city',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386dd6e5f417',
            'label' => 'State',
            'name' => 'compu_state',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386dd9f5f419',
            'label' => 'Country',
            'name' => 'compu_country',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386ddb05f41a',
            'label' => 'Öffnungszeiten',
            'name' => 'compu_offnungszeiten',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ),
          array(
            'key' => 'field_6386de015f41b',
            'label' => 'Corona-Regeln',
            'name' => 'compu_corona-regeln',
            'aria-label' => '',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '• FFP2-Maske nach eigenem Ermessen',
            'maxlength' => '',
            'rows' => '',
            'placeholder' => '',
            'new_lines' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'compustore-store',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
      ));

    endif;
  }


  /// ///////////////////////////////

  public function compu_stores_ajax_callback()
  {
    $compu_user_text = $_POST[ 'compu_search_text' ];
    $nonce           = $_POST[ 'compu_nonce' ];
    $action          = 'compu_nonce_action';
     if ( wp_verify_nonce($nonce, $action) ) {
      global $wpdb;
      $sql        = "SELECT post_title,ID FROM {$wpdb->prefix}posts WHERE post_type='compustore-store' AND post_status='publish' AND post_title LIKE '%$compu_user_text%'";
      $all_search = $wpdb -> get_results($sql);
       echo '<ul class="compu_main_search_list">';
      foreach ($all_search as $compu_map_result) {

        $compu_map_title   = $compu_map_result -> post_title;
        $compu_map_latlong = get_field('compu_latitude', $compu_map_result -> ID) .','. get_field('compu_longitude', $compu_map_result -> ID);
        $compu_map_street  = get_field('compu_street', $compu_map_result -> ID);
        $compu_map_post    = get_field('compu_postal_code', $compu_map_result -> ID);
        $compu_map_city    = get_field('compu_city', $compu_map_result -> ID);
        $compu_map_state   = get_field('compu_state', $compu_map_result -> ID);
        $compu_map_phone   = get_field('compu_phone', $compu_map_result -> ID);

        printf("<li data-id='%s' data-title='%s' data-position='%s'  data-street='%s' data-post-code='%s' data-city='%s' data-state='%s' data-phone='%s'>%s</li>", $compu_map_result -> ID, $compu_map_title, $compu_map_latlong,
          $compu_map_street, $compu_map_post, $compu_map_city, $compu_map_state, $compu_map_phone, $compu_map_title
        );

      }
       echo '</ul>';
    } else {
      echo "You are not authorized";
    }
    die();
  }

}
