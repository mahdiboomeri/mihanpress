document.addEventListener('DOMContentLoaded', shortLink);

function shortLink() {
    'use strict';

    /**
     * Copy Post Short Link
     */
    let short_link = document.getElementsByClassName('short-link');

    if (short_link.length > 0) {
        short_link[0].addEventListener('click', function () {

            let element = document.getElementById('post_short_link');
            let copy_temp;

            document.body.insertAdjacentHTML('afterbegin', '<input id="copy_temp">');
            copy_temp = document.getElementById('copy_temp');
            copy_temp.value = element.innerHTML;
            copy_temp.select();
            document.execCommand('copy');

            M.toast({
                html: mihanpress_js_translate.copied_short_link
            });

            document.body.removeChild(copy_temp);
        });
    }
}