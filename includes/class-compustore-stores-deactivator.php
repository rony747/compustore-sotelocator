<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://tirony.me
 * @since      1.0.0
 *
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Compustore_Stores
 * @subpackage Compustore_Stores/includes
 * @author     t.i.rony <touhidul747@gmail.com>
 */
class Compustore_Stores_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
flush_rewrite_rules();
	}

}
