document.addEventListener('DOMContentLoaded', WPMenu);

function WPMenu() {
    /**
     * Disable Menu Link
     */
    const links = document.querySelectorAll('.menu-item.no-link > a');

    links.forEach((link) => {
        link.removeAttribute('href');
    });

    /**
     * Calculate Megamenu Position
     */
    const megamenus = document.querySelectorAll('.mihanpress-megamenu > .sub-menu') as NodeListOf<HTMLElement>;

    if (megamenus.length > 0) {
        megamenus.forEach((megamenu) => {
            let element_width = megamenu.getBoundingClientRect().left + megamenu.offsetWidth + 50;
            let megamenu_right = -(window.innerWidth - element_width);
            
            megamenu.style.right = megamenu_right + 'px';
        });
    }
}