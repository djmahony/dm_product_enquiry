<?php
/*
Plugin Name: eSterling Product Enquiry
Plugin URI:  http://www.esterling.co.uk
Description: Set up a new "enquiry" post type and allow customers to enquire about products
Version:     1.0
Author:      eSterling (Dan Mahony)
Author URI:  http://www.esterling.co.uk
*/

class es_product_enquiry {

    public function __construct() {
        add_action('woocommerce_product_options_general_product_data', [$this, 'es_product_enquiry_checkbox']);
    }

    public function es_product_enquiry_checkbox() {
        echo '<div class="options_group">';
        woocommerce_wp_checkbox(
            array(
                'id'      => 'enquiry_product',
                'value'   => get_post_meta( get_the_ID(), 'enquiry_product', true ),
                'label'   => 'Enquiry Product?',
                'desc_tip' => true,
                'description' => 'Add to basket will be replaced with an enquiry button if ticked',
            )
        );
        echo '</div>';
    }
}

$es_product_enquiry = new es_product_enquiry();