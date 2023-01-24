<?php

defined( 'ABSPATH' ) || exit;

class es_enquiry_post_type {

    public function __construct() {
        $this->_init();
    }

    protected function _init() {
        add_action('init', [$this, 'register_post_type']);
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
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

    public function add_meta_box() {
        add_meta_box(
            'product-enquiry-details',
            __( 'Product Enquiry Details', 'esterling' ),
            array($this, 'product_enquiry_meta_box_callback'),
            'product_enquiry'
        );
    }

    public function product_enquiry_meta_box_callback($post) {
        wp_nonce_field( $this->_prefix.'_save_meta_box_data', $this->_prefix.'_meta_box_nonce' );

        $post_id = $post->ID;

        $name = get_post_meta($post_id, '_enquiry_name', true);
        $company = get_post_meta($post_id, '_enquiry_company', true);
        $email = get_post_meta($post_id, '_enquiry_email', true);
        $phone = get_post_meta($post_id, '_enquiry_phone', true);
        $product_id = get_post_meta($post_id, '_enquiry_product_id', true);

        echo '<div class="inside"><div class="panel-wrap"><div class="panel-container">';
        echo '<div class="options_group"><label for="enquiry_product">Product ID: </label><input type="text" id="enquiry_product" name="enquiry_product" value="' . $product_id . '" disabled /> <a href="' . get_edit_post_link($product_id) . '" target="_blank">View Product (' . get_the_title($product_id) . ')</a></div>';
        echo '<div class="options_group"><label for="enquiry_name">Name: </label><input type="text" id="enquiry_name" name="enquiry_name" value="' . $name . '" /></div>';
        echo '<div class="options_group"><label for="enquiry_company">Company: </label><input type="text" id="enquiry_company" name="enquiry_company" value="' . $company . '" /></div>';
        echo '<div class="options_group"><label for="enquiry_email">Email: </label><input type="text" id="enquiry_email" name="enquiry_email" value="' . $email . '" /></div>';
        echo '<div class="options_group"><label for="enquiry_phone">Phone: </label><input type="text" id="enquiry_phone" name="enquiry_phone" value="' . $phone . '" /></div>';
        echo '</div></div></div>';
    }
}