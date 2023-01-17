<?php
/*
Plugin Name: eSterling Product Enquiry
Plugin URI:  http://www.esterling.co.uk
Description: Set up a new "enquiry" post type and allow customers to enquire about products
Version:     1.0
Author:      eSterling (Dan Mahony)
Author URI:  http://www.esterling.co.uk
*/

defined( 'ABSPATH' ) || exit;

require_once('inc/classes/admin.php');
require_once('inc/classes/enquiry_post_type.php');

class es_product_enquiry {

    private const TEMPLATE_DIRECTORY = 'esterling/woocommerce/product/';

    public function __construct() {
        // instantiate admin class and set up admin fields
        $this->_init();
    }

    protected function _init() {

        $admin = new es_product_enquiry_admin();
        $post_type = new es_enquiry_post_type();

        add_action('wp', [$this, 'woocommerce_actions']);

        // Add Ajax actions for form submission
        add_action( 'wp_ajax_es_product_enquiry_submit', array($this, 'add_enquiry') );
        add_action( 'wp_ajax_nopriv_es_product_enquiry_submit', array($this, 'add_enquiry') );
    }

    /**
     * Check if product is an enquiry only product
     * @return bool
     */
    protected function _is_enquiry_product() {
        global $post;

        // return if product has "enquiry_product" meta

        return get_post_meta($post->ID, 'enquiry_product', true) === 'yes';
    }

    /**
     * Register required hooks
     * @return void
     */
    public function woocommerce_actions() {
        // action to replace add to cart button if enquiry product
        if($this->_is_enquiry_product()) {

            add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            add_action('woocommerce_single_product_summary', [$this, 'render_enquiry_button']);
            add_action('wp_footer', [$this, 'render_enquiry_form']);
        }
    }

    /**
     * Enqueue scripts and styles
     * @return void
     */
    public function enqueue_assets() {

        wp_register_script('es_product_enquiry_js', plugin_dir_url( __FILE__ ) . 'assets/js/product_enquiry.js', '', '', true);
        wp_enqueue_script('es_product_enquiry_js');
        wp_localize_script('es_product_enquiry_js', 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('ajax-nonce')]);
        wp_enqueue_style('es_product_enquiry_css', plugin_dir_url( __FILE__ ) . 'assets/css/style.css');
    }

    /**
     * Load the template for enquiry button
     * @return void
     */
    public function render_enquiry_button() {

        $this->_load_template('enquiry_button.php');
    }

    /**
     * Load template for the enquiry form
     * @return void
     */
    public function render_enquiry_form() {
        global $product;
        $this->_load_template('enquiry_form.php', ['id' => $product->get_id(), 'name' => $product->get_title()]);
    }

    /**
     * Load a template from the theme, or use default in plugin
     * @param string $template
     * @param $args
     * @return void
     */
    protected function _load_template(string $template, $args = []) {

        // If the passed template exists in the set theme then load it from there
        if($overridden_template = locate_template(self::TEMPLATE_DIRECTORY . $template, '')) {
            load_template($overridden_template, true, $args);
        } else {
            // Otherwise load it from the template directory in the plugin
            load_template(plugin_dir_path( __FILE__ ) . '/templates/' . $template, true, $args);
        }
    }

    public function add_enquiry() {

        try {
            $product = wc_get_product($_POST['product_id']);

            $title = $_POST['name'] . ' ' . ' enquiry for ' . $product->get_name();
            $post_args = [
                'post_title' => $title,
                'post_content' => $_POST['enquiry'],
                'post_type' => 'product_enquiry',
                'meta_input' => [
                    '_enquiry_product_id' => $_POST['product_id'],
                    '_enquiry_email' => $_POST['email']
                ]
            ];

            wp_insert_post($post_args);

            $to = 'daniel@esterilng.co.uk';
            $subject = $title;
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $email_body = "<p>You have received an enquiry from " . $_POST['email'] . "</p>
                <p>Name: " . $_POST['name'] . "</p>
                <p>Email: " . $_POST['email'] . "</p>
                <p>Product: " . $product->get_id() . " - " . $product->get_name() . "</p>
                <p>Enquiry: " . $_POST['enquiry'] . "</p>";

            wp_mail($to, $subject, $email_body, $headers);

        } catch(Exception $e) {

        }
        die;
    }

}

$es_product_enquiry = new es_product_enquiry();