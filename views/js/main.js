$(document).on('click', '#close-display-top-bar-mfp', function() {

    $("#close-display-top-bar-mfp-content").hide();
    $("header").css("margin-top", "0");


    const cookieName = 'mfp_topbar';
    const cookieValue = '1';
    const expirationDays = 7;

    // Obliczenie daty wygaśnięcia pliku cookie
    let expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + expirationDays);

    // Ustawienie pliku cookie
    document.cookie = cookieName + '=' + cookieValue + '; expires=' + expirationDate.toUTCString() + '; path=/';

});
