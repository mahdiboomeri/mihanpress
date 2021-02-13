document.addEventListener('DOMContentLoaded', collapsible);

function collapsible() {
    'use strict';

    /**
     * Init Sidenav Collapsible
     */
    let sidenav_collapsible = document.querySelectorAll('.right-sidenav-collapsible');
    M.Collapsible.init(sidenav_collapsible);
}