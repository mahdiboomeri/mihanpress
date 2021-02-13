document.addEventListener('DOMContentLoaded', () => {
    WooAddedToCart(() => {
        M.toast({
            html: mihanpress_js_translate.added_to_cart
        });
    });
});

export default function WooAddedToCart(event) {
    'use strict';

    /**
     * Added to Cart Message for Woocommerce (Vanilla JS)
     * You can use the following jquery code to avoid further compatibility issues
     * jQuery(document.body).on("added_to_cart", function () {});
     */
    let buttons = document.querySelectorAll('.ajax_add_to_cart');

    buttons.forEach(item => {
        item.addEventListener('click', () => {
            const refreshIntervalId = setInterval(() => {
                if (!item.classList.contains('loading')) {

                    event();

                    clearInterval(refreshIntervalId);
                }
            }, 100);
        });
    });
}