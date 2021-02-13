document.addEventListener('DOMContentLoaded', stickyHeader);


function stickyHeader() {
    /**
     * Fixed header on scroll
     */
    const header = document.getElementById('fix-on-scroll');

    if (header) {
        let headerScrollTop: string = header.getAttribute('data-scroll-top')!;
        let hideOnScroll = document.querySelector('.hide-on-scroll') as HTMLElement;
        let replacehead = document.getElementById('replacehead') as HTMLElement;

        replacehead.style.height = header.offsetHeight + 'px';

        if (hideOnScroll) {
            hideOnScrollFunc(header, hideOnScroll, replacehead, headerScrollTop);

        } else {
            normalFixed(header, replacehead, headerScrollTop)
        }
    }
}

function hideOnScrollFunc(
    header: HTMLElement,
    hideOnScroll: HTMLElement,
    replacehead: HTMLElement,
    headerScrollTop: string
) {
    let lastScrollPosition: number;
    let newScrollPosition: number = 0;

    let hideOnScrollTop = header.offsetHeight + 20
    let negativeHideOnScrollTop = hideOnScrollTop - (2 * hideOnScrollTop); // Negative value of hideOnScroll

    hideOnScroll.style.top = negativeHideOnScrollTop + 'px';

    window.addEventListener('scroll', function () {


        if (document.body.scrollTop > +headerScrollTop || document.documentElement.scrollTop > +headerScrollTop) {
            lastScrollPosition = window.pageYOffset;

            header.classList.add('fix-header-visible');
            replacehead.classList.add('d-block');

            // Scrolling down
            if (newScrollPosition < lastScrollPosition && lastScrollPosition > 50) {
                header.style.top = negativeHideOnScrollTop + 'px';
                // Scrolling up
            } else if (newScrollPosition > lastScrollPosition) {
                hideOnScroll.style.top = 0 + 'px';
            }
        } else {
            header.style.top = negativeHideOnScrollTop + 'px';
            header.classList.remove('fix-header-visible');
            replacehead.classList.remove('d-block');
        }

        newScrollPosition = lastScrollPosition;
    }, true);
}


function normalFixed(
    header: HTMLElement,
    replacehead: HTMLElement,
    headerScrollTop: string
) {
    let lastScrollPosition: number;

    window.addEventListener('scroll', function () {

        if (document.body.scrollTop > +headerScrollTop || document.documentElement.scrollTop > +headerScrollTop) {

            lastScrollPosition = window.scrollY;
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