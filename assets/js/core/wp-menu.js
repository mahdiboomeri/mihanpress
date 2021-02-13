document.addEventListener('DOMContentLoaded', WPMenu);

function WPMenu() {
    'use strict';

    /**
     * Disable Menu Link
     */
    let links = document.querySelectorAll('.menu-item.no-link > a');
    links.forEach((link) => {
        link.removeAttribute('href');
    });

    /**
     * Calculate Megamenu Position
     */
    let megamenus = document.querySelectorAll('.mihanpress-megamenu > .sub-menu');

    if (megamenus.length > 0) {
        megamenus.forEach((megamenu) => {
            let element_width = megamenu.getBoundingClientRect().left + megamenu.offsetWidth + 50;
            let megamenu_right = -(window.innerWidth - element_width);
            
            megamenu.style.right = megamenu_right + 'px';
        });
    }
}