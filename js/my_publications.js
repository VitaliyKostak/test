let buttonPublicationAdder = document.getElementById('button_publication_adder');
document.getElementById('my_publication_text').oninput = function () {
    let publicateTextLength = this.value.length;
    if (publicateTextLength != 0) {
        if (buttonPublicationAdder.hasAttribute('disabled')) {
            buttonPublicationAdder.removeAttribute('disabled');
        }
    }
    else {
        if (buttonPublicationAdder.hasAttribute('disabled') == false) {
            buttonPublicationAdder.setAttribute("disabled", "disabled");;
        }
    }
}