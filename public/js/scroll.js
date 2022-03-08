function scrollToPosition() {
    localStorage.setItem("scrollTop", document.body.scrollTop);
    window.onload = function () {
        var scroll = parseInt(localStorage.getItem('scrollTop'));
        if (!isNaN(scroll))
            document.body.scrollTop = scroll
    }
}
