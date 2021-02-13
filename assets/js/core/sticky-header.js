document.addEventListener('DOMContentLoaded', stickyHeader);


function stickyHeader() {
    'use strict';

    /**
     * Fixed header on scroll
     */
    let header = document.getElementById('fix-on-scroll');

    if (!header) {
        return;
    }

    let new_scroll_position = 0;
    let last_scroll_position;
    let header_scroll_top = header.dataset.scrollTop;
    let hide_on_scroll = document.querySelector('.hide-on-scroll');
    let replacehead = document.getElementById('replacehead');

    replacehead.style.height = header.offsetHeight + 'px';

    if (hide_on_scroll) {
        let hide_on_scroll_top = header.offsetHeight + 20
        let n_hide_on_scroll_top = hide_on_scroll_top - (2 * hide_on_scroll_top); // Negative value of hide_on_scroll

        hide_on_scroll.style.top = n_hide_on_scroll_top + 'px';

        window.addEventListener('scroll', function () {


            if (document.body.scrollTop > header_scroll_top || document.documentElement.scrollTop > header_scroll_top) {
                last_scroll_position = window.pageYOffset;

                header.classList.add('fix-header-visible');
                replacehead.classList.add('d-block');

                // Scrolling down
                if (new_scroll_position < last_scroll_position && last_scroll_position > 50) {
                    header.style.top = n_hide_on_scroll_top + 'px';
                    // Scrolling up
                } else if (new_scroll_position > last_scroll_position) {
                    hide_on_scroll.style.top = 0 + 'px';
                }
            } else {
                header.style.top = n_hide_on_scroll_top + 'px';
                header.classList.remove('fix-header-visible');
                replacehead.classList.remove('d-block');
            }

            new_scroll_position = last_scroll_position;
        }, true);

    } else {

        window.addEventListener('scroll', function () {

            if (document.body.scrollTop > header_scroll_top || document.documentElement.scrollTop > header_scroll_top) {
                last_scroll_position = window.scrollY;
                header.classList.add('fix-header-visible');
                header.classList.add('animated');
                header.classList.add('fadeInDown');
                replacehead.classList.add('d-block');
            } else {
                header.classList.remove('fix-header-visible');
                header.classList.remove('animated');
                header.classList.remove('fadeInDown');
                replacehead.classList.remove('d-block')
            }
        }, true);
    }
}