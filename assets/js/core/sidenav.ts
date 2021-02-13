document.addEventListener('DOMContentLoaded', sideNav);

function sideNav() {
    /**
     * Desktop Sidenav
     */
    const desktopSidenav = document.querySelectorAll('.desktop-sidenav');
    const desktopSidenavTrigger = document.querySelector('.sidenav-desktop-trigger');
    let options = {};

    if (desktopSidenavTrigger) {

        M.Sidenav.init(desktopSidenav, options = {
            edge: desktopSidenavTrigger.getAttribute('data-position'),
            draggable: false
        });

    }

    /**
     * Mobile Sidenav
     */
    const mobileSidenav = document.querySelectorAll('.right-sidenav');

    M.Sidenav.init(mobileSidenav, options = {
        edge: document.body.classList.contains('rtl') === false ? 'left' : 'right'
    });
}