document.addEventListener('DOMContentLoaded', preloaderHide);

function preloaderHide() {
    /**
     * Hide Preloader After Page Loaded
     */
    const preloader = document.getElementById('preloader-wrap');

    if (preloader) {
        preloader.classList.add('preloader-wrap--hidden');
    }
}