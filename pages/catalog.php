<?php

require_once('header.php');

?>

<h1>Добро пожаловать в Каталог</h1>

<div class="goods" id="goods">

</div>


<form id="pageCh" action="catalog.handle.php">
    <input id="pageVal" style="width: 30px;" min="1" type="number" value="1" name="page" placeholder="page">
</form>
<!-- ------------------------------ -->

<script>
    var jsonData;

    function submitOrder(data) {
        console.log($("[name='phone']").val());
        console.log($("[name='amount']").val());
        console.log($("[name='address']").val());
        if ($("[name='phone']").val() == undefined ||
            $("[name='amount']").val() == undefined ||
            $("[name='address']").val() == undefined) {

            $("#orderform").append($("<div class='orderr price' style='color:red'>Данные указаны не верно!</div>"))
        } else {

            $.ajax({
                type: "POST",
                url: "catalog_handler.php",
                data: {
                    goodid: jsonData[data].id
                },
                success: function(response) {
                    if (response) {
                        $("#orderform").append($("<div>Успех! Ожидайте звонка оператора.</div>"));
                    } else {
                        $("#orderform").append($("<div>Неудача, попробуйте позже или братитесь по горячей линии!</div>"));
                    }
                    console.log(res);

                }
            })
        }

    }

    function makeOrder(data) {
        $(".full-size .good-btn").remove();
        $(".full-size").append($("<form stype='width:100%' id='orderform'>"))
        $("#orderform").append($("<div>Контактный номер телефона: </div>"));
        $("#orderform").append($("<input name='phone' type='tel' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}'>"));
        $("#orderform").append($("<div>Объем заказа:</div>"));
        $("#orderform").append($("<input name='amount' type='number' min=1 max=1000>"));
        $("#orderform").append($("<div>Адрес доставки:</div>"));
        $("#orderform").append($("<input name='address'><br>"));
        $(".full-size").append($("<button onclick='submitOrder(" + data + ")' class='good-btn'>Заказать</button>"));
        console.log('success');

    }

    function focusGood(data) {
        console.log(data);

        $(".goods").empty();
        $(".goods").append($("<div class='full-size'>"), {})
        $(".full-size").append($("<h2>"), {});
        $(".full-size h2").text(jsonData[data].lable);
        $(".full-size").append($("<img src='/FurWorks/goods/" + jsonData[data].picture + "'>"), {});

        $(".full-size").append($("<div class='full-desc'>"));
        $(".full-size .full-desc").text(jsonData[data].description);
        $(".full-size").append($("<div class='price'>Цена: " + jsonData[data].price + " руб.</div>"))
        $(".full-size").append($("<div class='avail'>"))
        if (jsonData[data].availability == 1) {
            $(".avail").text("Есть в наличии.");
            if (getCookie("userlogin") == undefined) {
                $(".full-size").append($("<div class='price' style='margin: 10px 0 10px 0;'>Пожалуйста, авторизуйтесь для оформления заказа</div>"));
                $(".full-size").append($("<button disabled class='good-btn'>Заказать</button>"));
            } else {
                $(".full-size").append($("<button onclick='makeOrder(" + data + ")' class='good-btn'>Заказать</button>"))
            }
        } else {
            $(".avail").text("Нет в наличии.");
            $(".full-size").append($("<button disabled class='good-btn'>Заказать</button>"));
        }

    }

    function getList() {
        $.ajax({
            type: "POST",
            url: "catalog_handler.php",
            data: {
                page: $("#pageVal").val()
            },
            success: function(response) {
                jsonData = JSON.parse(response);
                document.getElementById("goods").innerHTML = "";
                for (let i = 0; i < jsonData.length; ++i) {
                    document.getElementById("goods").innerHTML += "<div data-num='" + i + "' data-label='" + jsonData[i].lable + "' data-description='" + jsonData[i].description + "' data-availability='" + jsonData[i].availability + "' data-pic='" + jsonData[i].pic + "' onclick='focusGood(" + i + ");'  class='good'  id='" + i + "'><img src='/FurWorks/goods/" + jsonData[i].picture + "' alt='pic'<p>" + jsonData[i].lable + "</p><button  class='good-btn'>Подробнее</button></div>";
                }

            }
        })
    }
    $(document).ready(function() {
        $(".pageCh").submit(getList());
        $(".pageCh").on("input", function() {
            $(this).submit();
        })
    });
</script>

<style>
    .goods {
        display: flex;
        flex-flow: wrap row;
        justify-content: space-around;
    }

    .good {
        display: flex;
        flex-flow: nowrap column;
        justify-content: space-between;
        width: 40%;
        min-width: 300px;
        height: 400px;
        border: 1px solid #422371;
        border-radius: 20px;
        margin: 20px;
        text-align: center;
        max-width: 300px;
    }


    .goods img {
        border-radius: 20px;
        height: 70%;
    }

    .good-btn {
        border-radius: 0px 0px 20px 20px;
        height: auto;
        padding: 10px;
        width: 100%
    }

    .good-btn:focus {
        outline: none;
    }

    .full-size {
        width: 80%;
        margin: 20px;
        padding: 20px 20px 0 20px;
        display: flex;
        flex-flow: nowrap column;
        align-items: center;
        border: 1px black solid;
        border-radius: 20px;
    }

    .full-size img {
        margin: 10px 0 10px 0;
        width: 60%;
        height: auto;

    }

    .avail {
        text-align: left;
        color: silver;
        font-size: 0.8em;
    }


    .full-size .good-btn {

        margin-top: 10px;
        border-radius: 20px;
        font-size: 1.2em;
        height: auto;
        padding: 10px;
        width: 100%
    }

    .price {
        font-size: 1.3;
        color: #422371;
        font-style: italic;

    }

    input {
        width: 100%;
    }
</style>

<?php

require_once('footer.php');

?>