import WooAddedToCart from './added-to-cart.js';

document.addEventListener('DOMContentLoaded', masonry);

function masonry() {
    'use strict';

    /**
     * Masonry Grid on Archive Pages Using Macy.js library
     */
    let grid_items = document.getElementsByClassName('masonry-grid');

    if (grid_items.length > 0) {
        for (let i = 0; i < grid_items.length; i++) {
            let item = grid_items[i];
            let columns = {
                desktop: parseInt(item.dataset.column),
                tablet: parseInt(item.dataset.columnTablet),
                mobile: parseInt(item.dataset.columnMobile)
            };

            item.classList.add('masonry-grid-' + i);

            const masonry = new Macy({
                container: '.masonry-grid-' + i,
                trueOrder: false,
                waitForImages: false,
                useOwnImageLoader: true,
                mobileFirst: true,
                columns: columns.mobile,
                breakAt: {
                    1200: columns.desktop,
                    940: columns.tablet,
                    520: columns.mobile,
                },
            });

            for (i; i <= 3; i++) {
                setTimeout(() => {
                    masonry.recalculate(true);
                }, 1000);
            }

            WooAddedToCart(() => {
                masonry.recalculate(true);
            });

        }
    }
}