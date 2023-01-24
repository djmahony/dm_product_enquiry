<?php

defined( 'ABSPATH' ) || exit;

class es_product_enquiry_admin {

    protected $_prefix = 'es_product_enquiry';

    public function __construct() {
        $this->_init();
    }

    public function _init() {
        add_action('woocommerce_product_options_general_product_data', [$this, 'es_product_enquiry_checkbox']);
        add_action('woocommerce_process_product_meta', [$this, 'save_enquiry_checkbox']);
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_styles'));
    }

    public function es_product_enquiry_checkbox() {
        echo '<div class="options_group">';
        woocommerce_wp_checkbox(
            array(
                'id'      => 'es_enquiry_product',
                'value'   => get_post_meta( get_the_ID(), 'enquiry_product', true ),
                'label'   => 'Enquiry Product?',
                'desc_tip' => true,
                'description' => 'Add to basket will be replaced with an enquiry button if ticked',
            )
        );
        echo '</div>';
    }

    public function save_enquiry_checkbox($id) {
        $super = isset( $_POST[ 'enquiry_product' ] ) && 'yes' === $_POST[ 'enquiry_product' ] ? 'yes' : 'no';
        update_post_meta( $id, 'enquiry_product', $super );
    }

    public function admin_enqueue_styles() {
        wp_enqueue_style( 'es-product-enquiry-admin', plugins_url( '../../assets/css/admin.css', __FILE__ ) );
    }
}