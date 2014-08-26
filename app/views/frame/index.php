<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Скидочный сервис uClicker</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="http://reset5.googlecode.com/hg/reset.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lobster&subset=latin,cyrillic,latin-ext" rel="stylesheet" type="text/css">
    <style>
        .logo-title{
            font-family: 'Lobster', cursive;
            text-align: center;
            color: #416086;
            font-size: 36px;
            margin: 20px 0;
        }
        .logo-title span{
            color: #8AA6CC;
        }
        p{
            font-family: arial, sans-serif;
            padding: 5px;
            font-size: 13px;
            line-height: 17px;
        }
        .row{
            margin: 10px 140px;
        }
        .row-ico{
            margin: 20px 140px;
            text-align: center;
        }
        .col-ico{
            display: inline-block;
            margin: 5px;
        }
    </style>
</head>
<body>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<script src="http://api.odnoklassniki.ru/js/fapi5.js" defer="defer"></script>
<script type="text/javascript">

    /**
     *
     */
    VK.init({
        apiId: 4335971
    });

    /**
     *
     */
    window.fbAsyncInit = function() {
        FB.init({
            appId      : 1449687905310910,
            xfbml      : true,
            version    : 'v2.0'
        });
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    /**
     *
     */
    var rParams = FAPI.Util.getRequestParameters();
    FAPI.init(rParams["api_server"], rParams["apiconnection"],
        /*
         * Первый параметр:
         * функция, которая будет вызвана после успешной инициализации.
         */
        function() {
            alert("Инициализация прошла успешно");
            // здесь можно вызывать методы API

            FAPI.UI.postMediatopic({
                media:[
                    {
                        type: 'text',
                        text: '<?= $text ?>'
                    },
                    {
                        type: 'link',
                        url: '<?= $href ?>'
                    }
                ]
            }, false);

        },
        /*
         * Второй параметр:
         * функция, которая будет вызвана, если инициализация не удалась.
         */
        function(error) {
            alert("Ошибка инициализации");
        }
    );

    function doVk(){
        VK.Auth.login(function(data){
            console.log(data);
            var visitor_uid = 0;
            if (data.session && data.session.user && data.session.user.id) visitor_uid = data.session.user.id;
            VK.Api.call('wall.post', {
                message: '<?= $text ?>',
                attachments: '<?= $href ?>'
            }, function(data) {
                var post_id = 0;
                if (data.response && data.response.post_id) {
                    post_id = data.response.post_id;
                }
                if (post_id > 0) {
                    $.ajax({
                        url: '/connect/success',
                        dataType: 'json',
                        type: 'get',
                        data: {
                            post_id: post_id,
                            visitor_uid: visitor_uid,
                            token: '<?= $quest_token ?>'
                        },
                        success: function(data){
                            alert('Скидка получена');
                        }
                    });
                } else {
                    // TODO: error message
                }
                //window.opener.postMessage('ucl_message:post_id:' + post_id, '*');
            });
        }, 8192);
    }
    function doOk(){
        //
    }
    function doFb(){
        FB.login(function(response) {
            console.log(response);

            FB.api(
                "/me/feed",
                "POST",
                {
                    message: '<?= $text ?>',
                    link: '<?= $href ?>',
                    picture: 'http://www.mbm.ru/admin/kcfinder/upload/images/on(1).jpg',
                    name: 'name-3',
                    caption: 'caption-2',
                    description: 'description-1'
                },
                function (response) {
                    console.log(response);
                    if (response && !response.error) {
                        // TODO: error message
                    }

                    var post_id = 0;
                }
            );

        }, {scope: 'publish_actions'});
    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="logo-title"><span>u</span>Clicker</h1>
        </div>
    </div>
    <div class="row">
        <p>Вы хотите порекомендовать материал рекламодателя своим друзьям.</p>
        <p>Совершая это действие, Вы соглашаететсь разместить рекламные материалы на своей странице в социальной сети. Рекламные материалы будут доступны вашим друзьям.</p>
    </div>
    <div class="row-ico" style="width: ">
        <div class="col-ico"><a href="#"><img src="/packages/socico/vk-128.png" alt="" onclick="doVk(); return false;"></a></div>
        <div class="col-ico"><a href="#"><img src="/packages/socico/ok-128.png" alt="" onclick="doOk(); return false;"></a></div>
        <div class="col-ico"><a href="#"><img src="/packages/socico/fb-128.png" alt="" onclick="doFb(); return false;"></a></div>
    </div>
</div>
</body>
</html>