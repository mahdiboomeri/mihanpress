document.addEventListener('DOMContentLoaded', modals);

function modals() {
    'use strict';
    
    /**
     * Init Modals
     */
    let modals = document.querySelectorAll('.modal');
    let options = {};
    
    if (modals.length > 0) {
        M.Modal.init(modals, options = {
            opacity: 0.9,
        })
    }
}