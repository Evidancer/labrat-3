<?php

require_once('header.php');

$_SESSION['cur_page'] = 'catalog';
setcookie("cur_page", 'catalog', time() + 3600);
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


    function checkOrders() {
        $.ajax({
            type: "POST",
            url: "catalog_handler.php",
            data: {
                getorders: true
            },
            success: function(response) {
                var orders = JSON.parse(response);
                console.log(orders);
                document.getElementById("goods").innerHTML = "";
                for (let i = 0; i < orders.length; ++i) {
                    $(".goods").append($("<div class='order order" + i + "'>"), {});
                    $(".order" + i + "").append($("<div>ID заказа: " + orders[i][0].id + "</div>"), {});
                    $(".order" + i + "").append($("<div>Дата заказа: " + orders[i][0].time + "</div>"), {});
                    $(".order" + i + "").append($("<div>ID товар: " + orders[i][0].amount + "</div>"), {});
                    $(".order" + i + "").append($("<div>Объем заказа:" + orders[i][0].amount + "</div>"), {});
                    $(".order" + i + "").append($("<div>Адрес доставки: " + orders[i][0].adress + "</div>"), {});
                    $(".order" + i + "").append($("<div>Телефон заказчика: " + orders[i][0].id + "</div>"), {});
                    $(".order" + i + "").append($("<div>Имя заказчика: " + orders[i][1].name + "</div>"), {});

                }
            }

        })

    }




    function createGood() {
        $(".goods").empty();
        $(".goods").append($("<div class='full-size'>"), {})
        $(".full-size").append($("<button class='back' onclick='getList()'>Назад</button>"))
        $(".full-size").append($("<div>Название товара</div>"), {});
        $(".full-size").append($("<input type='text' class='goodname'>"), {});
        $(".full-size").append($("<div>Название картинки</div>"), {});
        $(".full-size").append($("<input type='text' class='picname'>"), {});
        $("full-size").append($("<input type='file' value='Pfadf'>"))
        $(".full-size").append($("<div>Описание</div>"), {});
        $(".full-size").append($("<textarea class='gooddesc'></textarea>"), {});
        $(".full-size").append($("<div>Цена</div>"), {});
        $(".full-size").append($("<input type='number' class='goodprice'>"), {});
        $(".full-size").append($("<div>Наличие</div>"), {});
        $(".full-size").append($("<input type='checkbox' class='goodavail'>"), {});
        $(".full-size").append($("<button onclick='submitCreation()' class='good-btn'>Создать</button>"));
    }


    function submitCreation() {

        if ($(".goodname").val() != undefined &&
            $(".picname").val() != undefined &&
            $(".gooddesc").val() != undefined &&
            $(".goodprice").val() != undefined &&
            $(".goodavail").is(":checked") != undefined) {

            $.ajax({
                type: "POST",
                url: "catalog_handler.php",
                data: {
                    cgname: $(".goodname").val(),
                    cgpic: $(".picname").val(),
                    cgdesc: $(".gooddesc").val(),
                    cgprice: $(".goodprice").val(),
                    cgavail: $(".goodavail").is(':checked'),
                },
                success: function(response) {
                    console.log(response);
                    $(".good-btn").text('Успех');
                    window.location.href = 'catalog.php';
                }
            });
        } else {
            $(".good-btn").text('Заполните все поля!');
        }

    }


    function editGood(data) {
        console.log(data);

        $(".goods").empty();
        $(".goods").append($("<div class='full-size'>"), {})
        $(".full-size").append($("<button class='back' onclick='getList()'>Назад</button>"))

        $(".full-size").append($("<div>Название товара</div>"), {});
        $(".full-size").append($("<input type='text' class='goodname'>"), {});
        $(".goodname").val(jsonData[data].lable);
        $(".full-size").append($("<div>Название картинки</div>"), {});
        $(".full-size").append($("<input type='text' class='picname'>"), {});
        $(".picname").val(jsonData[data].picture);
        $(".full-size").append($("<div>Загрузить картинку</div>"), {}); ////////////////////
        $(".full-size").append($("<form class='imga' name='pic' action='catalog_handler.php' enctype='multipart/form-data' method='POST'>" +
            "<input type='hidden' name='MAX_FILE_SIZE' value='30000000' /><input name='pic' type='file'></form>")) ////////////////////
        $("full-size").append($("<input type='file' value='Pfadf'>"))
        $(".full-size").append($("<div>Описание</div>"), {});
        $(".full-size").append($("<textarea class='gooddesc'></textarea>"), {});
        $(".gooddesc").val(jsonData[data].description);
        $(".full-size").append($("<div>Цена</div>"), {});
        $(".full-size").append($("<input type='number' class='goodprice'>"), {});
        $(".goodprice").val(jsonData[data].price);
        $(".full-size").append($("<div>Наличие</div>"), {});
        $(".full-size").append($("<input type='checkbox' class='goodavail'>"), {});
        if (jsonData[data].availability === "1") {
            $(".goodavail").attr('checked', true);
        }
        $(".full-size").append($("<button onclick='submitEdit(" + data + ")' class='good-btn'>Сохранить</button>"));
    }

    function submitEdit(data) {

        if ($(".goodname").val() != undefined &&
            $(".picname").val() != undefined &&
            $(".gooddesc").val() != undefined &&
            $(".goodprice").val() != undefined &&
            $(".goodavail").is(":checked") != undefined) {

            $.ajax({
                type: "POST",
                url: "catalog_handler.php",
                data: {
                    gid: jsonData[data].id,
                    gname: $(".goodname").val(),
                    gpic: $(".picname").val(),
                    gdesc: $(".gooddesc").val(),
                    gprice: $(".goodprice").val(),
                    gavail: $(".goodavail").is(':checked') + 0,
                },
                success: function(response) {
                    console.log(response);
                    $(".good-btn").text('Успех');
                    $(".imga").submit();
                }
            });
        } else {
            $(".good-btn").text('Заполните все поля!');
        }

    }


    function submitOrder(data) {
        console.log($("[name='phone']").val());
        console.log($("[name='amount']").val());
        console.log($("[name='address']").val());
        if ($("[name='phone']").val() == undefined ||
            $("[name='amount']").val() == undefined ||
            $("[name='address']").val() == undefined) {

            $(".error").remove();
            $("#orderform").append($("<div class='orderr price error' style='color:red'>Данные указаны не верно!</div>"));

        } else if (getCookie("just_bought")) {
            $(".error").remove();
            $(".success").remove();
            $("#orderform").append($("<div class='orderr price error' style='color:red'>Нельзя совершать покупки слишком часто!</div>"));
        } else {

            $.ajax({
                type: "POST",
                url: "catalog_handler.php",
                data: {
                    goodid: jsonData[data].id,
                    phone: $("[name='phone']").val(),
                    amount: $("[name='amount']").val(),
                    adress: $("[name='address']").val(),
                },
                success: function(response) {
                    if (response) {
                        $(".error").remove();
                        $("#orderform").append($("<div class='success'>Успех! Ожидайте звонка оператора.</div>"));
                    } else {
                        $(".error").remove();
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
        $(".full-size").append($("<button class='back' onclick='getList()'>Назад</button>"))
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
                if (getCookie('is_admin')) {
                    document.getElementById("goods").innerHTML += "<input type='button' class='create' onclick='createGood()' value='Создать товар'>";
                    document.getElementById("goods").innerHTML += "<input type='button' class='create' onclick='checkOrders()' value='Посмотреть заказы'>";
                    for (let i = 0; i < jsonData.length; ++i) {
                        document.getElementById("goods").innerHTML += "<div data-num='" + i + "' data-label='" + jsonData[i].lable + "' data-description='" + jsonData[i].description + "' data-availability='" + jsonData[i].availability + "' data-pic='" + jsonData[i].pic + "' onclick='editGood(" + i + ");'  class='good'  id='" + i + "'><img src='/FurWorks/goods/" + jsonData[i].picture + "' alt='pic'<p>" + jsonData[i].lable + "</p><button  class='good-btn'>Редактировать</button></div>";
                    }
                } else {
                    for (let i = 0; i < jsonData.length; ++i) {
                        document.getElementById("goods").innerHTML += "<div data-num='" + i + "' data-label='" + jsonData[i].lable + "' data-description='" + jsonData[i].description + "' data-availability='" + jsonData[i].availability + "' data-pic='" + jsonData[i].pic + "' onclick='focusGood(" + i + ");'  class='good'  id='" + i + "'><img src='/FurWorks/goods/" + jsonData[i].picture + "' alt='pic'<p>" + jsonData[i].lable + "</p><button  class='good-btn'>Подробнее</button></div>";
                    }
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
    .create {
        font-size: 1.2em;
    }

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

    .gooddesc {
        width: 100%;
        height: 4em;
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

    .back {
        font-size: 1em;
        border-radius: 20px;
        height: auto;
        padding: 10px;
        width: 30%
    }

    .good-btn:focus {
        outline: none;
    }

    .full-size {
        width: 80%;
        margin: 20px;
        padding: 0 20px 0 20px;
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

    .order {
        width: 100%;
        border: 1px dashed black;
        margin: 10px;
    }

    input {
        width: 100%;
    }
</style>

<?php

require_once('footer.php');

?>