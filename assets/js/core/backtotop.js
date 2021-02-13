document.addEventListener('DOMContentLoaded', backToTop);

function backToTop() {
    'use strict';

    /**
     * Back to Top Action
     */
    let backbtn = document.getElementById('backtotop');

    if (backbtn) {
        window.addEventListener('scroll', () => {
            if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                backbtn.classList.add('visible')
            } else {
                backbtn.classList.remove('visible')
            };
        }, true);

        backbtn.addEventListener('click', (event) => {
            document.documentElement.scrollTop = 0;
            event.preventDefault();
        });
    }
}