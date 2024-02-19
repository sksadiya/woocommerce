<?php
/*
 * Template Name: Custom Cart Template
 */

get_header();

// Get cart items using WooCommerce functions
$cart_items = WC()->cart->get_cart();

?>
<div class="container py-5">
    <div class="row">
        <?php
    include 'includes/cart-items.php';
    ?>
        
        <?php
    include 'includes/cart-summary.php';
    ?>
        

<?php get_footer(); ?>
