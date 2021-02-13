declare const Macy;

import wooAddedToCart from './added-to-cart';

document.addEventListener('DOMContentLoaded', masonry);

function masonry() {
    /**
     * Masonry Grid on Archive Pages Using Macy.js library
     */
    const gridItems = document.getElementsByClassName('masonry-grid') as HTMLCollection;

    if (gridItems.length > 0) {

        for (let i = 0; i < gridItems.length; i++) {

            const item = gridItems[i];
            const columns = {
                desktop: item.getAttribute('data-column'),
                tablet: item.getAttribute('data-column-tablet'),
                mobile: item.getAttribute('data-column-mobile')
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

            wooAddedToCart(() => {
                masonry.recalculate(true);
            });

        }
    }
}