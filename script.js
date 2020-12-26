"use strict";
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function validateEmail(email) {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    return reg.test(String(email).toLowerCase());
}





$(document).ready(function () {

    console.log("AHAHAHAHAHH");

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
            $.ajax({
                type: "POST",
                url: "header.php",
                data: {
                    break: true
                },
                success: function (responce) {
                    console.log(responce);
                    window.location.href = "main.php";
                }
            });
        });
        $(".auth-link").on("click", function () {
            window.location.href = "main.php";
        });
    }
})


