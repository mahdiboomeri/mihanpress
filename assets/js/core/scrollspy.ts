document.addEventListener('DOMContentLoaded', () => {
    scrollSpy('.mp-scrollspy-section')
});

function scrollSpy(selector: string) {
    /**
     * ScrollSpy
     */
    const section = document.querySelectorAll(selector) as NodeListOf<HTMLElement>;
    let sections = {};

    section.forEach((item) => {
        sections[item.id] = item.offsetTop;
    });

    window.addEventListener('scroll', () => {
        let scrollPosition = document.documentElement.scrollTop + 80 || document.body.scrollTop + 80;

        for (let i in sections) {
            if (sections[i] <= scrollPosition) {
                const activeSection = document.querySelector('.scrollspy-active');
                const activeLink = document.querySelector(`a[href*=${i}]`);

                if (activeLink && activeSection) {
                    activeSection.classList.remove('scrollspy-active');
                    activeLink.classList.add('scrollspy-active');
                }
            }
        }
    });

}