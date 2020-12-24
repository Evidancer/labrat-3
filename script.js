function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

$(document).ready(function () {

    $(".reg-link").on("click", function () {
        window.location.href = "reg.php";
    });

    $(".auth-link").on("click", function () {
        window.location.href = "auth.php";
    });

    if (getCookie("userlogin") != undefined) {
        console.log(getCookie("userlogin"));
        $(".auth-link").text(getCookie("userlogin"));
        $(".reg-link").text("ВЫЙТИ");
        $(".reg-link").off("click");
        $(".auth-link").off("click");
        $(".reg-link").on("click", function () {
            document.cookie = "userlogin=" + getCookie("userlogin") + "; max-age = 0";
            window.location.href = "main.php";
        });
        $(".auth-link").on("click", function () {
            window.location.href = "";
        });
    }
})
