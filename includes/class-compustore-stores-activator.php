<?php

/**
 * Fired during plugin activation
 *
 * @link       https://tirony.me
 * @since      1.0.0
 *
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/includes
 * @author     t.i.rony <touhidul747@gmail.com>
 */
class Compustore_Stores_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-compustore-stores-public.php';
    $pubClass = new Compustore_Stores_Public(COMPUSTORE_STORES_PLUGINNAME, COMPUSTORE_STORES_VERSION);
    $pubClass->create_store_cpt();
    flush_rewrite_rules();
	}

}
