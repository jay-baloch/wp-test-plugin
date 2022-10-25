<?php
/**
 *
 * @link              https://wordpress.com/
 * @since             1.0.0
 * @package           jzTestPlugin
 *
 * Plugin Name:       Jz test plugin
 * Plugin URI:        https://wordpress.com/
 * Description:       Plugin for Test purpose
 * Version:           1.0.0
 * Author:            Jahanzaib Baloch
 * Author URI:        https://wordpress.com/
 * License:           Copyrights 2022
 * Text Domain:       jz
 * Domain Path:       /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

if( !class_exists( 'Jz_Instance' ) ) {

	class Jz_Instance {
	        
    /**
     * Class constructor
     */          
    function __construct() {
                                
      $this->define_constants();

    }
    
    /**
     * Setup plugin constants.
     *
     * @since 1.0.0
     * @return void
     */
    public function define_constants() {

			define( 'JZ_VERSION', '1.0.0' );
			define( 'JZ_PLUGIN', 'jz_test_plugin');
			define( 'JZ_URL_PATH', plugin_dir_url( __FILE__ ) );
			define( 'JZ_PLUGIN_PATH', plugin_dir_path(__FILE__) );
			define( 'JZ_BASE_PATH', dirname( plugin_basename( __FILE__ ) ) );
      
    }
    


    /**
     * Include the required files.
     *
     * @since 1.0.0
     * @return void
     */
    public function includes() {


      require_once JZ_PLUGIN_PATH . 'public/class-jz-public.php';


      //  intialize the main instance
			$jz_plugin = new JZ_Public();

    }
    

    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-agile-store-locator-activator.php
     */
    public function activate() {
      
      require_once JZ_PLUGIN_PATH . 'includes/class-jz-activator.php';
      
      JZ_Activator::activate();
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-agile-store-locator-deactivator.php
     */
    public function deactivate() {
      
    }
	}
}



/**
 * [jz_init Initialize the extension. Note that this gets called on the "plugins_loaded" filter, so WooCommerce classes are guaranteed to exist]
 * @return [type] [description]
 */
function jz_init() {

  	//	Initialize the Plugin
    $jz_instance = new Jz_Instance();
    $jz_instance->includes();


}


/**
 * [JZ_activator Run the activation code of the Plugin]
 * @return [type] [description]
 */
function JZ_activator() {

  //  Initialize the Jz_Instance
  $jz_instance = new Jz_Instance();
  $jz_instance->activate();
}



register_activation_hook( __FILE__, 'JZ_activator');

add_action( 'plugins_loaded', 'jz_init', 11 );



