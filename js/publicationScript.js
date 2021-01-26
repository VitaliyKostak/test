function countComments(publicationId) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/test/ajax/ajaxCountComments.php');
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById(publicationId).querySelector('.btn-comments-publication').innerHTML = 'Коментарі (' + xhr.responseText + ')';
        }
    }
    xhr.send('publicationId=' + publicationId);
}
function ajaxDeleteComment() {
    let deleteCommentsButtons = document.getElementsByClassName('deleteComment');
    if (deleteCommentsButtons != null) {
        for (i = 0; i < deleteCommentsButtons.length; i++) {
            deleteCommentsButtons[i].onclick = function () {
                let commentId = this.getAttribute('data-commentId');
                let wrapComment = this.parentNode;
                let publicationId = wrapComment.parentNode.parentNode.parentNode.getAttribute('id');
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'http://localhost/test/ajax/ajaxDeleteComment.php');
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        wrapComment.parentNode.removeChild(wrapComment);
                        countComments(publicationId);
                    }
                }
                xhr.send('commentId=' + commentId);

            }
        }

    }
}
function ajaxDeletePublications() {
    let deletePublicationsButtons = document.getElementsByClassName('delete-publication');
    if (deletePublicationsButtons != null) {
        for (i = 0; i < deletePublicationsButtons.length; i++) {
            deletePublicationsButtons[i].onclick = function () {
                let publicationId = this.parentNode.getAttribute('id');
                let wrapPublication = this.parentNode;
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'http://localhost/test/ajax/ajaxDeletePublication.php');
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        wrapPublication.parentNode.removeChild(wrapPublication);
                        document.getElementById('count-publications').innerHTML = 'Публікацій: ' + xhr.responseText;
                    }
                }
                xhr.send('publicationId=' + publicationId);

            }
        }
    }

}
let commentsButtons = document.getElementsByClassName('btn-comments-publication');
for (i = 0; i < commentsButtons.length; i++) {
    commentsButtons[i].onclick = function () {
        let commentButton = commentsButtons[i];
        let wrapBodyComments = this.parentElement.querySelector('.wrapBodyComments'); // Блок, що має відкритись при натисканні кнопки "Коментарі"
        if (wrapBodyComments.style.display == 'none') {
            wrapBodyComments.style.display = 'block';
            let buttonCommentAdder = wrapBodyComments.querySelector('.buttonCommentAdder');
            if (buttonCommentAdder != null) {
                buttonCommentAdder.onclick = function () {
                    let commentValue = wrapBodyComments.querySelector('.commentValue').value;
                    let commentLength = wrapBodyComments.querySelector('.commentValue').value.length;
                    let publicatationId = this.getAttribute('data-publicatationId');
                    let outPutData = commentValue + '?' + publicatationId;
                    if (commentLength >= 1) {
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', 'http://localhost/test/ajax/ajaxAddComment.php');
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                if (xhr.responseText != '') {
                                    wrapComments = wrapBodyComments.querySelector('.wrapComments');
                                    if (wrapComments == null) {
                                        let div = document.createElement('div');
                                        div.className = "wrapComments";
                                        div.innerHTML = '<div class="wrapComment">' + xhr.responseText + '</div">';
                                        wrapBodyComments.append(div);
                                        wrapBodyComments.querySelector('.commentValue').value = '';
                                    }
                                    else {
                                        let div = document.createElement('div');
                                        div.className = "wrapComment";
                                        div.innerHTML = xhr.responseText;
                                        wrapComments.prepend(div);
                                        wrapBodyComments.querySelector('.commentValue').value = '';
                                    }
                                    ajaxDeleteComment();
                                    countComments(publicatationId);
                                }
                                else {
                                    window.location.reload();
                                }
                            }
                        }
                        xhr.send('outPutData=' + outPutData);
                    }

                }
            }

        }
        else {
            wrapBodyComments.style.display = 'none';
        }
    }

}

window.onload = function () {
    ajaxDeletePublications();
    ajaxDeleteComment();
}