document.addEventListener('DOMContentLoaded', ajaxLike);

function ajaxLike() {
    /**
     * Ajax Like Process
     */
    const ajaxLikeButton = document.querySelector('.ml-button') as HTMLElement;

    if (ajaxLikeButton) {
        ajaxLikeButton.addEventListener('click', function(event: Event) {
            const postId = this.dataset.postId;
            const security = this.dataset.nonce;
            const iscomment = this.dataset.iscomment;
            let allbuttons;

            if (iscomment === '1') {
                allbuttons = document.querySelector(`.ml-comment-button-${postId}`);
            } else {
                allbuttons = document.querySelector(`.ml-button-${postId}`);
            }
            
            if (postId !== '') {
                document.querySelector('.ml-icon')!.innerHTML = '<div class=\"like-loader\"></div>';

                const request = new XMLHttpRequest();

                request.open('POST', mihanpressObj.ajaxurl, true);
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                request.onload = function () {

                    const responseOutput = this.responseText;
                    const responseData = JSON.parse(responseOutput);
                    const icon = responseData.icon;
                    const count = responseData.count;

                    allbuttons.innerHTML = icon + count;

                    if (responseData.status === 'unliked') {

                        const likeText = mihanpressObj.like;

                        allbuttons.setAttribute('title', likeText);
                        allbuttons.classList.remove('liked');

                    } else {
                        const unlikeText = mihanpressObj.unlike;

                        allbuttons.setAttribute('title', unlikeText);
                        allbuttons.classList.add('liked');
                    }
                };

                const data = `action=mp_like_process&post_id=${postId}&nonce=${security}&is_comment=${iscomment}`;

                request.send(data);
            }
            
            // Prevent Browser default action
            event.preventDefault();
        });
    }
}