<div class="col-lg-3">
    <div class="card mb-3 border shadow-0">
        <div class="card-body">
            <div class="coupon">
                <div class="form-group">
                    <label class="form-label">
                        <?php esc_html_e('Have coupon?', 'cars_theme'); ?>
                    </label>
                    <div class="input-group">
                        <input type="text" name="coupon_code" class="form-control border" id="coupon_code" value=""
                            placeholder="<?php esc_attr_e('Coupon code', 'cars_theme'); ?>" />
                        <button type="submit" class="btn btn-light border" name="apply_coupon"
                            value="<?php esc_attr_e('Apply coupon', 'cars_theme'); ?>">
                            <?php esc_html_e('Apply', 'cars_theme'); ?>
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </div>



    <div class="card shadow-0 border">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <p class="mb-2">
                    <?php esc_html_e('Total price:', 'cars_theme'); ?>
                </p>
                <p class="mb-2" id="total_amount">
                    <?php echo wp_kses_post(WC()->cart->get_cart_total()); ?>
                </p>
            </div>
            <div class="d-flex justify-content-between">
                <p class="mb-2" >
                    <?php esc_html_e('Discount:', 'cars_theme'); ?>
                </p>
                <?php
                $discount_total = WC()->cart->get_cart_discount_total();
                if ($discount_total > 0) {
                    echo '<p class="mb-2 text-success" id="discount_amount">-' . wp_kses_post($discount_total) . '</p>';
                } else {
                    echo '<p class="mb-2 text-success" >-' . wp_kses_post('0.00') . '</p>';
                }
                ?>
            </div>
            <div class="d-flex justify-content-between">
                <p class="mb-2">
                    <?php esc_html_e('TAX:', 'cars_theme'); ?>
                </p>
                <p class="mb-2" id="tax-amount">
                    <?php echo wp_kses_post(WC()->cart->get_cart_contents_tax()); ?>
                </p>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <p class="mb-2" id="total_amount">
                    <?php esc_html_e('Total price:', 'cars_theme'); ?>
                </p>
                <p class="mb-2 fw-bold">
                    <?php echo wp_kses_post(WC()->cart->get_total()); ?>
                </p>
            </div>

            <div class="mt-3">
                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn btn-dark w-100 shadow-0 mb-2">
                    <?php esc_html_e('Make Purchase', 'cars_theme'); ?>
                </a>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-light w-100 border mt-2">
                    <?php esc_html_e('Back to shop', 'cars_theme'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- summary -->
</div>
</div>