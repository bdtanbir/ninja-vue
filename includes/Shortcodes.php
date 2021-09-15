<?php

namespace NINJAVUE;

/**
 * Shortcodes Handler
 */
class Shortcodes {

    public function __construct() {
        add_shortcode( 'helloninja', [$this, 'hello_ninja_callback'] );
        
    }


    public function hello_ninja_callback() {
        
        return '<h1>Hello Ninja VUE</h1>';
    }

}



