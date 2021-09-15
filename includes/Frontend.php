<?php

namespace NINJAVUE;

/**
 * Frontend Handler
 */
class Frontend {

    public function __construct()
    {
        add_shortcode( 'ninja-vue', [$this, 'render_frontend'] );
    }

    public function render_frontend($content) {
        wp_enqueue_style( 'ninja-vue-frontend' );
        wp_enqueue_script( 'ninja-vue-frontend');
        $content .= '<div id="vue-frontend-app"></div>';
        return $content;
    }

}




