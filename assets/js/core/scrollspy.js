document.addEventListener('DOMContentLoaded', () => {
    scrollSpy('.mp-scrollspy-section')
});

function scrollSpy(selector) {
    'use strict';

    /**
     * ScrollSpy
     */
    let section = document.querySelectorAll(selector);
    let sections = {};
    let i = 0;

    Array.prototype.forEach.call(section, (item) => {
        sections[item.id] = item.offsetTop;
    });

    window.addEventListener('scroll', () => {
        let scrollPosition = document.documentElement.scrollTop + 80 || document.body.scrollTop + 80;

        for (i in sections) {
            if (sections[i] <= scrollPosition) {
                document.querySelector('.scrollspy-active').classList.remove('scrollspy-active');
                document.querySelector('a[href*=' + i + ']').classList.add('scrollspy-active');
            }
        }
    });

}