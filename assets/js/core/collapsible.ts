declare const M;

document.addEventListener('DOMContentLoaded', collapsible);

function collapsible() {
    /**
     * Init Sidenav Collapsible
     */
    const sidenavCollapsible = document.querySelectorAll('.right-sidenav-collapsible');

    M.Collapsible.init(sidenavCollapsible);
}