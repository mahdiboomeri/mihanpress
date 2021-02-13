document.addEventListener('DOMContentLoaded', ajaxLike);

function ajaxLike() {
    'use strict';
    
    /**
     * Ajax Like Process
     */
    let ajax_like_button = document.querySelector('.ml-button');

    if (ajax_like_button) {
        ajax_like_button.addEventListener('click', function(event) {
            let post_id = this.dataset.postId;
            let security = this.dataset.nonce;
            let iscomment = this.dataset.iscomment;
            let allbuttons;

            if (iscomment === '1') {
                allbuttons = document.querySelector('.ml-comment-button-' + post_id);
            } else {
                allbuttons = document.querySelector('.ml-button-' + post_id);
            }
            
            if (post_id !== '') {
                function beforesend() {
                    document.querySelector('.ml-icon').innerHTML = '<div class=\"like-loader\"></div>';
                }
                beforesend();

                let request = new XMLHttpRequest();
                request.open('POST', mihanpress_js_translate.ajaxurl, true);
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                request.onload = function () {
                    let response_output = this.responseText;
                    let response_data = JSON.parse(response_output);
                    let icon = response_data.icon;
                    let count = response_data.count;

                    allbuttons.innerHTML = icon + count;

                    if (response_data.status === 'unliked') {
                        let like_text = mihanpress_js_translate.like;
                        allbuttons.setAttribute('title', like_text);
                        allbuttons.classList.remove('liked');
                    } else {
                        let unlike_text = mihanpress_js_translate.unlike;
                        allbuttons.setAttribute('title', unlike_text);
                        allbuttons.classList.add('liked');
                    }
                };

                let data = 'action=mp_like_process&post_id=' + post_id + '&nonce=' + security + '&is_comment=' + iscomment;
                request.send(data);
            }
            
            // Prevent Browser default action
            event.preventDefault();
        });
    }
}