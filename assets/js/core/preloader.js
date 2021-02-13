document.addEventListener('DOMContentLoaded', preloaderHide);

function preloaderHide() {
    'use strict';
    
    /**
     * Hide Preloader After Page Loaded
     */
    let preloader = document.getElementById('preloader-wrap');

    if (preloader) {
        preloader.classList.add('preloader-wrap--hidden');
    }
}