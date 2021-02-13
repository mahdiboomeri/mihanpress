declare const mihanpressObj;

document.addEventListener('DOMContentLoaded', shortLink);

function shortLink() {
    /**
     * Copy Post Short Link
     */
    const shortLink = document.getElementsByClassName('short-link');

    if (shortLink.length > 0) {
        shortLink[0].addEventListener('click', () => {

            const element = document.getElementById('post_short_link') as HTMLElement;
            let copyTemp;

            document.body.insertAdjacentHTML('afterbegin', '<input id="copy_temp">');
            copyTemp = document.getElementById('copy_temp');
            copyTemp.value = element.innerHTML;
            copyTemp.select();
            document.execCommand('copy');

            M.toast({
                html: mihanpressObj.copiedShortLink
            });

            document.body.removeChild(copyTemp);
        });
    }
}