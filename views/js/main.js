(function () {
    'use strict';

    var HEADER_SELECTORS = '.header-top, #header';

    function setHeaderOffset(value) {
        document.querySelectorAll(HEADER_SELECTORS).forEach(function (element) {
            element.style.marginTop = value;
        });
    }

    function adjustOffsetToBarHeight() {
        var bar = document.getElementById('close-display-top-bar-m4p-content');
        if (bar) {
            setHeaderOffset(bar.offsetHeight + 'px');
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', adjustOffsetToBarHeight);
    } else {
        adjustOffsetToBarHeight();
    }

    document.addEventListener('click', function (event) {
        if (!event.target.closest('#close-display-top-bar-m4p')) {
            return;
        }

        var bar = document.getElementById('close-display-top-bar-m4p-content');
        if (bar) {
            bar.style.display = 'none';
        }
        setHeaderOffset('0');

        var expirationDate = new Date();
        expirationDate.setDate(expirationDate.getDate() + 7);
        document.cookie = 'm4p_barinfofree=1; expires=' + expirationDate.toUTCString() + '; path=/; SameSite=Lax';
    });
})();
