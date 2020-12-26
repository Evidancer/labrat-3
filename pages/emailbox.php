<br>
<h2>Почта</h2>
<div class='emails'></div>


<script>
    $(document).ready(() => {
        $.ajax({
            type: "POST",
            url: "emailbox_handler.php",
            data: {
                getmail: true
            },
            success: function(response) {
                console.log(response);
                var emails = JSON.parse(response);

                for (let i = 0; i < emails.length; ++i) {
                    $(".emails").append($("<div class='email email" + i + "'>"), {});
                    $(".email" + i + "").append($("<div>ID письма: " + emails[i].id + "</div>"), {});
                    $(".email" + i + "").append($("<div>Автор письма: " + emails[i].author + "</div>"), {});
                    $(".email" + i + "").append($("<div>Письмо:<br>" + emails[i].text + "</div>"), {});
                }
            }
        });
    })
</script>

<style>
    .email {
        width: 100%;
        border: 1px dashed black;
        margin: 10px;
    }
</style>