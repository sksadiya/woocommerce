<div class="col-lg-9">
    <div class="card border shadow-0">
        <div class="m-4">
            <h4 class="card-title mb-4">Your shopping cart</h4>

            <?php
            if (!WC()->cart->is_empty()) {

                foreach ($cart_items as $cart_item_key => $cart_item):
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
                                        <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="nav-link">
                                            <?php echo esc_html($_product->get_name()); ?>
                                        </a>
                                        <p class="text-muted">
                                            <?php echo esc_html($_product->get_formatted_name()); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                            <div class="">
                                <text class="h6">
                                    <?php echo WC()->cart->get_product_price($_product); ?>
                                </text> <br>
                                <small class="text-muted text-nowrap">
                                    <?php echo WC()->cart->get_product_price($_product, 1, $cart_item['quantity']); ?> / per
                                    item
                                </small>
                            </div>
                        </div>
                        <div
                            class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                            <div class="float-md-start me-5 d-flex align-items-center">
                                <button class="btn btn-link px-2"
                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                    <i class="bi bi-dash"></i>
                                </button>


                                <?php
                                echo '<input type="number" id="quantity_' . esc_attr($cart_item_key) . '" class="form-control form-control-sm w-100 cart-quantity" name="cart[' . esc_attr($cart_item_key) . '][qty]" value="' . esc_attr($cart_item['quantity']) . '" aria-label="Product quantity" size="4" min="0" max="" step="1" placeholder="" inputmode="numeric" autocomplete="off" data-cart-item-key="' . esc_attr($cart_item_key) . '">';
                            ?>


                                <button class="btn btn-link px-2"
                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                    <i class="bi bi-plus"></i>
                                </button>

                            </div>

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
                <?php endforeach;
            } else {
                echo "<p>Your Cart is empty</p>";
            } ?>

        </div>
    </div>
</div>