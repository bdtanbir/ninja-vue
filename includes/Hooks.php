<?php

namespace NINJAVUE;


/**
 * Hooks Handler
 */
class Hooks {

    public function __construct() {

        add_filter( 'the_content', [$this, 'adding_custom_text_after_content'] );
        add_action( 'wp_head', [$this, 'add_meta_inside_wp_head'] );
        
    }

    public function adding_custom_text_after_content($content) {
        $after = '<h3>-- after content</h3>';
        $content = $content .$after;
        return $content;
    }

    public function add_meta_inside_wp_head() {
        ?>
        <meta name="description" content="I am From Ninja Vue" />
        <?php
    }

}



