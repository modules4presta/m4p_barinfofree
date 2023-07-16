$(document).on('click', '#close-display-top-bar-m4p', function() {

    $("#close-display-top-bar-m4p-content").hide();
    $(".body-desktop-header-style-w-1 .header-top").css("margin-top", "0");
    $(".body-desktop-header-style-w-2 .header-top").css("margin-top", "0");
    $(".body-desktop-header-style-w-3 .header-top").css("margin-top", "0");
    $(".body-desktop-header-style-w-4 .header-top").css("margin-top", "0");
    $(".body-desktop-header-style-w-5 .header-top").css("margin-top", "0");

    $("body:not(.body-desktop-header-style-w-1 ) #header").css("margin-top", "0");
    $("body:not(.body-desktop-header-style-w-2 ) #header").css("margin-top", "0");
    $("body:not(.body-desktop-header-style-w-3 ) #header").css("margin-top", "0");
    $("body:not(.body-desktop-header-style-w-4 ) #header").css("margin-top", "0");
    $("body:not(.body-desktop-header-style-w-5 ) #header").css("margin-top", "0");



    const cookieName = 'm4p_barinfofree';
    const cookieValue = '1';
    const expirationDays = 7;

    // Obliczenie daty wygaśnięcia pliku cookie
    let expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + expirationDays);

    // Ustawienie pliku cookie
    document.cookie = cookieName + '=' + cookieValue + '; expires=' + expirationDate.toUTCString() + '; path=/';

});
