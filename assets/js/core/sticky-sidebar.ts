declare const StickySidebar;

document.addEventListener('DOMContentLoaded', fixedSidebar);

function fixedSidebar() {
    /**
     * Sticky Sidebar using Slicky-sidebar.js
     */
    if (document.getElementsByClassName('sticky-sidebar').length > 0 && document.body.classList.contains('sticky-sidebar-on')) {
        new StickySidebar('#sticky-sidebar', {
            containerSelector: '#sticky-content',
            innerWrapperSelector: '.sidebar__inner',
            topSpacing: 20,
            bottomSpacing: 20,
            resizeSensor: true,
            minWidth: 1200
        });
    }
}