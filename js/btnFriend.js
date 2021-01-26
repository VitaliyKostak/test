
let friendButtons = document.getElementsByClassName('btnFriend');
for (i = 0; i < friendButtons.length; i++) {
    friendButtons[i].onmouseenter = function () {
        let requiredAction = this.classList[1];
        let buttonValue = this.value;
        if (requiredAction == 'btnAdded') {
            this.value = 'Видалити з друзів';
        }
        else if (requiredAction == 'btnFriendRequestOUT') {
            this.value = 'Відмінити відправлену заявку';
        }
    }
    friendButtons[i].onmouseleave = function () {
        let requiredAction = this.classList[1];
        if (requiredAction == 'btnAdded') {
            this.value = 'У вас у друзях';
        }
        else if (requiredAction == 'btnFriendRequestOUT') {
            this.value = 'Ви відправили заявку';
        }
    }
    friendButtons[i].onclick = function () {
        let requiredAction = this.classList[1];
        let UserId = this.getAttribute("data-user_id"); // id користувача (friend)
        let outPutData = requiredAction + '?' + UserId;
        outPutData = encodeURIComponent(outPutData);
        let thisButton = this;
        let thisButtonParent = thisButton.parentElement;
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://localhost/test/ajax/ajaxBtnFriend.php');
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText != '') {
                    if (thisButtonParent.getElementsByClassName('btnFriend').length == 2) {
                        thisButtonParent.removeChild(thisButton);
                        thisButton = thisButtonParent.querySelector('.btnFriend');
                    }
                    let receivedDataXHRarr = xhr.responseText.split('?');
                    thisButton.classList.remove(thisButton.classList[1]);
                    newRequiredAction = receivedDataXHRarr[0];
                    thisButton.classList.add(newRequiredAction);
                    thisButton.value = receivedDataXHRarr[1];
                }
                else {
                    window.location.reload();
                }

            }
        }
        xhr.send('outPutData=' + outPutData);
    }
}








