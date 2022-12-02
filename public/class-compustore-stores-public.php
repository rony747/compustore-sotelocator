<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://tirony.me
 * @since      1.0.0
 *
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/public
 * @author     t.i.rony <touhidul747@gmail.com>
 */
class Compustore_Stores_Public
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
   * @param string $plugin_name The name of the plugin.
   * @param string $version The version of this plugin.
   * @since    1.0.0
   */
  public function __construct($plugin_name, $version)
  {

    $this -> plugin_name = $plugin_name;
    $this -> version     = $version;
    add_shortcode('compustore_stores', [$this, 'compustore_stores_shortcode']);
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles()
  {
    wp_enqueue_style('leaflet-css', plugin_dir_url(__FILE__) . 'css/leaflet.css', array(), $this -> version, 'all');
    wp_enqueue_style('compu_main-style', plugin_dir_url(__FILE__) . 'css/compustore-stores-public.css', array(), $this -> version, 'all');

  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts()
  {

    wp_register_script('leaflet-js', plugin_dir_url(__FILE__) . 'js/leaflet.js', array('jquery'), $this -> version, true);
    wp_register_script('compu_main-js', plugin_dir_url(__FILE__) . 'js/compustore-stores-public.js', array('jquery'), $this -> version, true);
    $action      = 'compu_nonce_action';
    $compu_nonce = wp_create_nonce($action);
    wp_localize_script('compu_main-js', 'compu_map_data', ['ajax_url' => admin_url('admin-ajax.php'), 'compustore_nonce' => $compu_nonce, 'plugin_img_dir' => plugin_dir_url(__FILE__) . '/images/',]);


  }

  function create_store_cpt()
  {

    $labels = array(
      'name'                  => _x('Stores', 'Post Type General Name', 'compustore-stores'),
      'singular_name'         => _x('Store', 'Post Type Singular Name', 'compustore-stores'),
      'menu_name'             => _x('Stores', 'Admin Menu text', 'compustore-stores'),
      'name_admin_bar'        => _x('Store', 'Add New on Toolbar', 'compustore-stores'),
      'archives'              => __('Store Archives', 'compustore-stores'),
      'attributes'            => __('Store Attributes', 'compustore-stores'),
      'parent_item_colon'     => __('Parent Store:', 'compustore-stores'),
      'all_items'             => __('All Stores', 'compustore-stores'),
      'add_new_item'          => __('Add New Store', 'compustore-stores'),
      'add_new'               => __('Add New', 'compustore-stores'),
      'new_item'              => __('New Store', 'compustore-stores'),
      'edit_item'             => __('Edit Store', 'compustore-stores'),
      'update_item'           => __('Update Store', 'compustore-stores'),
      'view_item'             => __('View Store', 'compustore-stores'),
      'view_items'            => __('View Stores', 'compustore-stores'),
      'search_items'          => __('Search Store', 'compustore-stores'),
      'not_found'             => __('Not found', 'compustore-stores'),
      'not_found_in_trash'    => __('Not found in Trash', 'compustore-stores'),
      'featured_image'        => __('Store Icon', 'compustore-stores'),
      'set_featured_image'    => __('Set Store Icon', 'compustore-stores'),
      'remove_featured_image' => __('Remove Store Icon', 'compustore-stores'),
      'use_featured_image'    => __('Use as Store Icon', 'compustore-stores'),
      'insert_into_item'      => __('Insert into Store', 'compustore-stores'),
      'uploaded_to_this_item' => __('Uploaded to this Store', 'compustore-stores'),
      'items_list'            => __('Stores list', 'compustore-stores'),
      'items_list_navigation' => __('Stores list navigation', 'compustore-stores'),
      'filter_items_list'     => __('Filter Stores list', 'compustore-stores'),
    );
    $args   = array(
      'label'               => __('Store', 'compustore-stores'),
      'description'         => __('', 'compustore-stores'),
      'labels'              => $labels,
      'menu_icon'           => 'dashicons-store',
      'supports'            => array('title', 'thumbnail'),
      'taxonomies'          => array(),
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'menu_position'       => 65,
      'show_in_admin_bar'   => true,
      'show_in_nav_menus'   => true,
      'can_export'          => true,
      'has_archive'         => false,
      'hierarchical'        => false,
      'exclude_from_search' => true,
      'show_in_rest'        => true,
      'publicly_queryable'  => false,
      'capability_type'     => 'post',
    );
    register_post_type('compustore-store', $args);
  }

  /*
   * Register Store short code
 */
  function compustore_stores_shortcode()
  {
    $output = $this -> compustore_stores_htmls();
    return $output;
  }

  // Outputs all HTML for map
  function compustore_stores_htmls()
  {
    ob_start();
    wp_enqueue_script('leaflet-js');
    wp_enqueue_script('compu_main-js');
    $args      = [
      'post_type'      => 'compustore-store',
      'posts_per_page' => -1,
    ];
    $allStores = new WP_Query($args);
    if ( $allStores -> have_posts() ) {
      ?>
      <div class="compu_main_map_holder">
        <div class="compu_main_map_wrap">
          <div class="compu_main_map_left">
            <div class="compu_main_map_search">

              <input type="text" name="s" id="compu_search" placeholder="PLZ oder Ort eingeben "/>
              <button id="compu_search_btn" type="button"><img
                    src="<?php echo plugin_dir_url(__FILE__) . "/images/mapSearch.svg" ?>" alt="search"></button>

              <div id="compu_search_result_area">

              </div>

              <div id="comp_search_loader" class="lds-facebook">
                <div></div>
                <div></div>
                <div></div>
              </div>

            </div><!-- compu_main_map_search -->
            <div class="compu_main_map_list_wrap">
              <ul class="compu_main_map_list">
                <?php
                while ($allStores -> have_posts()) {
                  $allStores -> the_post(); ?>
                  <li id="cmi<?php echo get_the_ID(); ?>" data-id="<?php echo get_the_ID(); ?>"
                      data-position="<?php echo get_field('compu_latitude'); ?>,<?php echo get_field('compu_longitude'); ?>"
                      data-title="<?php echo get_the_title(); ?>"
                      data-street="<?php echo get_field('compu_street'); ?>"
                      data-post-code="<?php echo get_field('compu_postal_code'); ?>"
                      data-city="<?php echo get_field('compu_city'); ?>"
                      data-state="<?php echo get_field('compu_state'); ?>"
                      data-phone="<?php echo get_field('compu_phone'); ?>"
                  >

                    <div class="cmp_title">
                      <div class="cmp_title_text">
                        <h3><?php echo get_the_title(); ?></h3>
                      </div>
                      <div class="cmp_title_icon">
                        <?php echo get_the_post_thumbnail(); ?>
                      </div>
                      <div class="cmp_title_arrow">
                        <img class="store_expand_arrow"
                             src="<?php echo plugin_dir_url(__FILE__) . 'images/expand_arrow.svg' ?>" alt="store expand">
                      </div>
                    </div><!-- cmp_title -->
                    <div class="cmp_content">
                      <div class="cmp_content_wrap">
                        <div class="cmp_con_left">
                          <div class="cmp_con_left_top">
                            <h5>Kontaktdaten</h5>
                            <?php if ( get_field('compu_street') ): ?>
                              <p><?php the_field('compu_street'); ?></p>
                            <?php endif; ?>
                            <?php if ( get_field('compu_postal_code') || get_field('compu_city') ): ?>
                              <p><?php the_field('compu_postal_code'); ?>
                                <?php the_field('compu_city') ?></p>
                            <?php endif; ?>
                            <?php if ( get_field('compu_state') ): ?>
                              <p><?php the_field('compu_state'); ?></p>
                            <?php endif; ?>
                            <?php if ( get_field('compu_phone') || get_field('compu_email') ): ?>
                              <div class="cmp_con_left_phone">
                                <p><?php the_field('compu_phone'); ?></p>
                                <p><?php the_field('compu_email'); ?></p>
                              </div>
                            <?php endif; ?>
                          </div>
                          <div class="cmp_con_left_bottom">
                            <?php if ( get_field('compu_offnungszeiten') ): ?>
                              <h5>Öffnungszeiten</h5>
                              <p><?php the_field('compu_offnungszeiten'); ?></p>
                            <?php endif; ?>
                          </div>
                        </div>
                        <div class="cmp_con_right">
                          <?php if ( get_field('compu_corona-regeln') ): ?>
                            <h5>Corona-Regeln</h5>
                            <p><?php the_field('compu_corona-regeln'); ?></p>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div><!-- cmp_content -->

                  </li>

                <?php }
                ?>
              </ul>
            </div><!-- compu_main_map_list_wrap -->

          </div>
          <div class="compu_main_map_right">
            <div class="compu_main_maparea">
              <div class="compu_main_map_box" id="compu_map">

              </div>
            </div>
          </div>

        </div>
      </div>
      <?php
    }
    wp_reset_postdata();
    return ob_get_clean();
  }


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
        $compu_map_latlong = get_field('compu_latitude', $compu_map_result -> ID) . ',' . get_field('compu_longitude', $compu_map_result -> ID);
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
