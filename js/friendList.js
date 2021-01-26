window.onload = function () {
    let tabButtons = document.getElementsByClassName('tabName');
    for (let i = 0; i < tabButtons.length; i++) {
        tabButtons[i].onclick = function () {
            for (j = 0; j < tabButtons.length; j++) {
                if (tabButtons[j].classList.contains('activeTab')) {
                    tabButtons[j].classList.remove('activeTab');
                }
            }
            this.classList.add('activeTab');
            let tabBlocks = document.getElementsByClassName('tabBlock');
            for (k = 0; k < tabBlocks.length; k++) {
                tabBlocks[k].style.display = 'none';
                if (tabBlocks[k].classList.contains('activeTabBlock')) {
                    tabBlocks[k].classList.remove('activeTabBlock');
                }
            }
            tabBlocks[i].classList.add('activeTabBlock');
            tabBlocks[i].style.display = 'block';
        }
    }
}