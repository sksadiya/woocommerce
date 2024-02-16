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
        <!-- cart -->
        <div class="col-lg-9">
            <div class="card border shadow-0">
                <div class="m-4">
                    <h4 class="card-title mb-4">Your shopping cart</h4>

                    <?php foreach ($cart_items as $cart_item_key => $cart_item) :
                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                    ?>
                        <div class="row gy-3 mb-4">
                            <div class="col-lg-5">
                                <div class="me-lg-5">
                                    <div class="d-flex">
                                        <?php
                                       $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail', array('class' => 'border rounded me-3', 'style' => 'width: 96px; height: 96px;')), $cart_item, $cart_item_key);

                                       echo wp_kses_post($thumbnail);
                                       
                                        ?>
                                        <div class="">
                                            <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="nav-link"><?php echo esc_html($_product->get_name()); ?></a>
                                            <p class="text-muted"><?php echo esc_html($_product->get_formatted_name()); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                                <div class="">
                                    <?php
                                    $quantity_input = sprintf(
                                        '<select style="width: 100px;" class="form-select me-4" name="%s" value="%s">%s</select>',
                                        esc_attr("cart[{$cart_item_key}][qty]"),
                                        esc_attr($cart_item['quantity']),
                                        wc_get_stock_html($_product)
                                    );
                                    echo wp_kses_post($quantity_input);
                                    ?>
                                </div>
                                <div class="">
                                    <text class="h6"><?php echo WC()->cart->get_product_price($_product); ?></text> <br>
                                    <small class="text-muted text-nowrap"><?php echo WC()->cart->get_product_price($_product, 1, $cart_item['quantity']); ?> / per item </small>
                                </div>
                            </div>
                            <div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                                <div class="float-md-end">
                                    <?php
                                    echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                        '<a href="%s" class="btn btn-light border text-danger icon-hover-danger" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                        esc_html__('Remove this item', 'woocommerce'),
                                        esc_attr($product_id),
                                        esc_attr($_product->get_sku()),
                                        esc_html__('Remove', 'woocommerce')
                                    ), $cart_item_key);
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- <div class="border-top pt-4 mx-4 mb-4">
                        <p><i class="fas fa-truck text-muted fa-lg"></i> <?php esc_html_e('Free Delivery within 1-2 weeks', 'your-theme-domain'); ?></p>
                        <p class="text-muted">
                            <?php esc_html_e('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip', 'your-theme-domain'); ?>
                        </p>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- summary -->
        <div class="col-lg-3">
            <div class="card mb-3 border shadow-0">
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Have coupon?', 'your-theme-domain'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control border" name="" placeholder="<?php esc_attr_e('Coupon code', 'your-theme-domain'); ?>">
                                <button class="btn btn-light border"><?php esc_html_e('Apply', 'your-theme-domain'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow-0 border">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="mb-2"><?php esc_html_e('Total price:', 'your-theme-domain'); ?></p>
                        <p class="mb-2"><?php echo wp_kses_post(WC()->cart->get_cart_total()); ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-2"><?php esc_html_e('Discount:', 'your-theme-domain'); ?></p>
                        <p class="mb-2 text-success">-<?php echo wp_kses_post(WC()->cart->get_discount_total()); ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-2"><?php esc_html_e('TAX:', 'your-theme-domain'); ?></p>
                        <p class="mb-2"><?php echo wp_kses_post(WC()->cart->get_cart_contents_tax()); ?></p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <p class="mb-2"><?php esc_html_e('Total price:', 'your-theme-domain'); ?></p>
                        <p class="mb-2 fw-bold"><?php echo wp_kses_post(WC()->cart->get_total()); ?></p>
                    </div>

                    <div class="mt-3">
                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn btn-success w-100 shadow-0 mb-2"><?php esc_html_e('Make Purchase', 'your-theme-domain'); ?></a>
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn btn-light w-100 border mt-2"><?php esc_html_e('Back to shop', 'your-theme-domain'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- summary -->
    </div>
</div>

<?php get_footer(); ?>
