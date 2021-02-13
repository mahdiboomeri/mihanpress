declare const M;

declare const mihanpressObj;


document.addEventListener('DOMContentLoaded', () => {
    wooAddedToCart(() => {
        M.toast({
            html: mihanpressObj.addedToCart
        });
    });
});

export default function wooAddedToCart(event: () => void) {
    'use strict';

    /**
     * Added to Cart Message for Woocommerce (Vanilla JS)
     * You can use the following jquery code to avoid further compatibility issues
     * jQuery(document.body).on("added_to_cart", function () {});
     */
    const buttons = document.querySelectorAll('.ajax_add_to_cart');

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