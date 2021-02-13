document.addEventListener('DOMContentLoaded', modals);

function modals() {
    /**
     * Init Modals
     */
    const modals = document.querySelectorAll('.modal');
    let options = {};
    
    if (modals.length > 0) {
        M.Modal.init(modals, options = {
            opacity: 0.9,
        })
    }
}