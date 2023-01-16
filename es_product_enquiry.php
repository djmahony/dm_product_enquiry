<?php
/*
Plugin Name: eSterling Product Enquiry
Plugin URI:  http://www.esterling.co.uk
Description: Set up a new "enquiry" post type and allow customers to enquire about products
Version:     1.0
Author:      eSterling (Dan Mahony)
Author URI:  http://www.esterling.co.uk
*/

require_once('inc/classes/admin.php');
require_once('inc/classes/enquiry_post_type.php');

class es_product_enquiry {

    public function __construct() {
        // instantiate admin class and set up admin fields
        $admin = new es_product_enquiry_admin();
    }


}

$es_product_enquiry = new es_product_enquiry();