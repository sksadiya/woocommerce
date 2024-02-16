<?php
function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('cars_script', get_theme_file_uri("/build/index.js"), array('jquery'), '1.0', true);
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.min.css', array(), '5.0.0');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.0.0', true);
    wp_enqueue_style('bootstrap-icons', get_template_directory_uri() . '/node_modules/bootstrap-icons/font/bootstrap-icons.css', array(), '1.0');
  
  wp_enqueue_style('main_styles',get_stylesheet_uri());

  wp_localize_script('cars_script', 'cart_params', array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce'    => wp_create_nonce('cart_nonce'),
));
   
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


// Add WooCommerce support
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support() {
    add_theme_support('woocommerce');
}


function get_cart_items() {
  check_ajax_referer('cart_nonce', 'nonce');

  ob_start();

  wc_get_template('cart/mini-cart.php');

  $output = ob_get_clean();

  echo $output;

  die();
}
add_action('wp_ajax_get_cart_items', 'get_cart_items');
add_action('wp_ajax_nopriv_get_cart_items', 'get_cart_items');

function remove_from_cart() {
  check_ajax_referer('cart_nonce', 'nonce');

  $product_id = $_POST['product_id'];

  // Remove the product from the cart
  WC()->cart->remove_cart_item($product_id);

  // Output updated cart items
  get_cart_items();

  die();
}
add_action('wp_ajax_remove_from_cart', 'remove_from_cart');
add_action('wp_ajax_nopriv_remove_from_cart', 'remove_from_cart');

?>