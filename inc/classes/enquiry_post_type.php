<?php

defined( 'ABSPATH' ) || exit;

class es_enquiry_post_type {

    public function __construct() {
        $this->_init();
    }

    protected function _init() {
        add_action('init', [$this, 'register_post_type']);
    }

    function register_post_type() {
        register_post_type('product_enquiry',
            array(
                'labels'      => array(
                    'name'          => __('Product Enquiries', ''),
                    'singular_name' => __('Product Enquiry', ''),
                ),
                'public'      => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'has_archive' => true,
            )
        );
    }
}