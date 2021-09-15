<?php
namespace NINJAVUE;

/**
 * Admin Pages Handler
 */
class NV_Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register our menu page
     *
     * @return void
     */
    public function admin_menu() {
        $capability = 'manage_options';
        $slug       = 'ninja-vue';

        $hook = add_menu_page( 
            __( 'Ninja Vue', 'ninja-vue' ), 
            __( 'Ninja Vue', 'ninja-vue' ), 
            $capability, 
            $slug, 
            [ $this, 'ninja_vue_menu_page_template' ], 
            'dashicons-admin-users',
            50
        );

        add_action( 'load-' . $hook, [ $this, 'init_hooks'] );
    }

    /**
     * Initialize our hooks for the admin page
     * @return void
     */
    public function init_hooks() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'ninja-vue-admin' );
        wp_enqueue_script( 'ninja-vue-admin' );
    }

    /**
     * Render our admin page
     * @return void
     */
    public function ninja_vue_menu_page_template() {
        echo '<div class="wrap"><div id="ninja-vue-admin-app"></div></div>';
    }
}
