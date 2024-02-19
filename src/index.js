jQuery(document).ready(function($) {
    // Function to get and display cart items
    function displayCartItems() {
        $.ajax({
            type: 'POST',
            url: cart_params.ajax_url,
            data: {
                action: 'get_cart_items',
                nonce: cart_params.nonce,
            },
            success: function(response) {
                $('#cart-offcanvas-body').html(response);
            },
        });
    }
    displayCartItems();

    // Remove item from cart without fade-out effect
    $('#cart-offcanvas-body').on('click', '.remove_from_cart_button', function(e) {
        e.preventDefault();

        console.log("Clicked Remove Button");

        var productId = $(this).data('product-id');

        // Show overlay
        $.blockUI({ message: null, overlayCSS: { backgroundColor: '#000', opacity: 0.6 } });

        $.ajax({
            type: 'POST',
            url: cart_params.ajax_url,
            data: {
                action: 'remove_from_cart',
                nonce: cart_params.nonce,
                product_id: productId,
            },
            success: function(response) {
                $.unblockUI();
                displayCartItems();
            },
            error: function(response) {
                console.log(response);
            },
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    // Your existing JavaScript code here
    jQuery(function ($) {
        $('body').on('click', 'button[name="apply_coupon"]', function () {
            var coupon_code = $('#coupon_code').val();

            $.ajax({
                type: 'POST',
                url: cart_params.ajax_url,
                data: {
                    action: 'apply_coupon',
                    coupon_code: coupon_code,
                },
                success: function (response) {
                    if (response) {
                        location.reload();
                    } else {
                        // Handle coupon application failure.
                        alert('Coupon code could not be applied.');
                    }
                }
            });
        });
    });
});




document.addEventListener('DOMContentLoaded', function () {
    var quantityInputs = document.querySelectorAll('.cart-quantity');
    quantityInputs.forEach(function (input) {
        input.addEventListener('change', function () {
            var cartItemKey = input.dataset.cartItemKey;
            var quantity = input.value;

            console.log('cart_item_key:', cartItemKey);
            console.log('quantity:', quantity);
            // Send AJAX request to update cart
            var data = {
                action: 'update_cart',
                cart_item_key: cartItemKey,
                quantity: quantity,
                security: cart_params.nonce // Use the localized nonce
            };
           

            jQuery.post(cart_params.ajax_url, data, function (response) {
                if (response.success) {
                    var cartTotals = response.data.cart_totals;

                    if (cartTotals) {
                        // Update cart totals, discounts, tax, and grand total
                        jQuery('#total_amount').html(cartTotals.cart_total || '');
                        jQuery('#discount_amount').html('-' + (cartTotals.cart_discount || '0.00'));
                        jQuery('#tax-amount').html(cartTotals.cart_tax || '');
                        jQuery('#grand_total').html(cartTotals.cart_total_with_tax || '');

                        location.reload();
                    } else {
                        console.error('Invalid cart totals data in the AJAX response:', response);
                    }
                } else {
                    console.error('Error in AJAX response:', response);
                }
            }).fail(function (xhr, status, error) {
                console.error('AJAX request failed:', status, error);
            });
        });
    });
});
