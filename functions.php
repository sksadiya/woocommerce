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

  WC()->cart->remove_coupons();

  // Output updated cart items
  get_cart_items();

  die();
}
add_action('wp_ajax_remove_from_cart', 'remove_from_cart');
add_action('wp_ajax_nopriv_remove_from_cart', 'remove_from_cart');





// function apply_coupon() {
//     $coupon_code = sanitize_text_field($_POST['coupon_code']);

//      WC()->cart->remove_coupons();

//     if (WC()->cart->apply_coupon($coupon_code)) {
//         echo 'success';
//     } else {
//         echo 'failure';
//     }

//     wp_die();
// }
// add_action('wp_ajax_apply_coupon', 'apply_coupon');
// add_action('wp_ajax_nopriv_apply_coupon', 'apply_coupon');



function apply_coupon() {
  // Check if a coupon code is provided
  if (isset($_POST['coupon_code'])) {
      $coupon_code = sanitize_text_field($_POST['coupon_code']);

      // Check if the cart is not empty
      if (!WC()->cart->is_empty()) {
          // Apply the coupon to the cart
          if (WC()->cart->apply_coupon($coupon_code)) {
              echo 'success';
          } else {
              echo 'failure';
          }
      } else {
          echo 'cart_empty';
      }
  } else {
      echo 'no_coupon_code';
  }

  wp_die();
}
add_action('wp_ajax_apply_coupon', 'apply_coupon');
add_action('wp_ajax_nopriv_apply_coupon', 'apply_coupon');


function update_cart_quantity_callback() {
  if (isset($_POST['cart_item_key']) && isset($_POST['quantity'])) {
      $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
      $quantity = sanitize_text_field($_POST['quantity']);
      WC()->cart->set_quantity($cart_item_key, $quantity);
      WC()->cart->calculate_totals();

      // Get updated cart totals
      $cart_totals = WC()->cart->get_totals();

      if ($cart_totals) {
          // Return updated cart totals
          wp_send_json_success(array('cart_totals' => $cart_totals));
      } else {
          $error_message = 'Failed to retrieve cart totals after update';
          error_log($error_message);
          wp_send_json_error($error_message);
      }
   } 
   else {
      $error_message = 'Invalid request - POST parameters not set';
      error_log($error_message);
      wp_send_json_error($error_message);
  }
}

add_action('wp_ajax_update_cart', 'update_cart_quantity_callback');
add_action('wp_ajax_nopriv_update_cart', 'update_cart_quantity_callback');


?>