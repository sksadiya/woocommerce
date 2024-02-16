/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
jQuery(document).ready(function ($) {
  // Function to get and display cart items
  function displayCartItems() {
    $.ajax({
      type: 'POST',
      url: cart_params.ajax_url,
      data: {
        action: 'get_cart_items',
        nonce: cart_params.nonce
      },
      success: function (response) {
        $('#cart-offcanvas-body').html(response);
      }
    });
  }
  displayCartItems();

  // Remove item from cart without fade-out effect
  $('#cart-offcanvas-body').on('click', '.remove_from_cart_button', function (e) {
    e.preventDefault();
    console.log("Clicked Remove Button");
    var productId = $(this).data('product-id');

    // Show overlay
    $.blockUI({
      message: null,
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6
      }
    });
    $.ajax({
      type: 'POST',
      url: cart_params.ajax_url,
      data: {
        action: 'remove_from_cart',
        nonce: cart_params.nonce,
        product_id: productId
      },
      success: function (response) {
        $.unblockUI();
        displayCartItems();
      },
      error: function (response) {
        console.log(response);
      }
    });
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map