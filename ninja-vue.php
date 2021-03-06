<?php
/*
Plugin Name: Ninja Vue
Plugin URI: 
Description: Ninja Vue
Version: 0.1
Author: Tanbir Ahmed
Author URI: http://tanbirahmed.unaux.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ninja-vue
Domain Path: /languages
*/

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Ninja_Vue class
 * @class Ninja_Vue The class that holds the entire Ninja_Vue plugin
 */
final class Ninja_Vue {

    /**
     * Plugin version
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Holds various class instances
     * @var array
     */
    private $container = array();

    /**
     * Constructor for the Ninja_Vue class
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {

        $this->define_constants();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
    }

    /**
     * Initializes the Ninja_Vue() class
     *
     * Checks for an existing Ninja_Vue() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Ninja_Vue();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'NV_VERSION', $this->version );
        define( 'NV_FILE', __FILE__ );
        define( 'NV_PATH', dirname( NV_FILE ) );
        define( 'NV_INCLUDES', NV_PATH . '/includes' );
        define( 'NV_URL', plugins_url( '', NV_FILE ) );
        define( 'NV_ASSETS', NV_URL . '/assets' );
    }

    /**
     * Load the plugin after all plugins are loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {

        $installed = get_option( 'ninja_vue_installed' );

        if ( ! $installed ) {
            update_option( 'ninja_vue_installed', time() );
        }

        update_option( 'NV_version', NV_VERSION );
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {

    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {

        require_once NV_INCLUDES . '/Assets.php';
        require_once NV_INCLUDES . '/Hooks.php';
        require_once NV_INCLUDES . '/Shortcodes.php';

        if ( $this->is_request( 'admin' ) ) {
            require_once NV_INCLUDES . '/Admin.php';
        }
        if ( $this->is_request( 'frontend' ) ) {
            require_once NV_INCLUDES . '/Frontend.php';
        }

        if ( $this->is_request( 'ajax' ) ) {}
    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks() {

        add_action( 'init', array( $this, 'init_classes' ) );

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes() {

        // Admin
        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin'] = new NINJAVUE\NV_Admin();
        }

        // Frontend Render
        if ( $this->is_request( 'frontend' ) ) {
            $this->container['frontend'] = new NINJAVUE\Frontend();
        }

        // Ajax
        if ( $this->is_request( 'ajax' ) ) {}

        // Assets
        $this->container['assets'] = new NINJAVUE\NV_Assets();

        // Hooks
        $this->container['hooks'] = new NINJAVUE\Hooks();

        // Shortcodes
        $this->container['hooks'] = new NINJAVUE\Shortcodes();
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'ninja-vue', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();

            case 'ajax' :
                return defined( 'DOING_AJAX' );

            case 'rest' :
                return defined( 'REST_REQUEST' );

            case 'cron' :
                return defined( 'DOING_CRON' );

            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );

        }
    }

} // Ninja_Vue

$ninja_vue = Ninja_Vue::init();
