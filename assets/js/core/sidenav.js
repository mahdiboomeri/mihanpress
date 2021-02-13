document.addEventListener('DOMContentLoaded', sideNav);

function sideNav() {
    'use strict';

    /**
     * Desktop Sidenav
     */
    let desktop_sidenav = document.querySelectorAll('.desktop-sidenav');
    let desktop_sidenav_trigger = document.querySelector('.sidenav-desktop-trigger');
    let options = {};

    if (desktop_sidenav_trigger) {
        M.Sidenav.init(desktop_sidenav, options = {
            edge: desktop_sidenav_trigger.dataset.position,
            draggable: false
        });
    }

    /**
     * Mobile Sidenav
     */
    let mobile_sidenav = document.querySelectorAll('.right-sidenav');

    M.Sidenav.init(mobile_sidenav, options = {
        edge: document.body.classList.contains('rtl') === false ? 'left' : 'right'
    });
}