<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Скидочный сервис uClicker</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="http://reset5.googlecode.com/hg/reset.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lobster&subset=latin,cyrillic,latin-ext" rel="stylesheet" type="text/css">

    <link href="/packages/responsivslides/responsiveslides.css" rel="stylesheet" type="text/css">
    <script src="/packages/responsivslides/responsiveslides.min.js"></script>

    <style>
        .logo-title{
            font-family: 'Lobster', cursive;
            text-align: center;
            color: #416086;
            font-size: 36px;
            margin: 12px 0;
        }
        .logo-title span{
            color: #8AA6CC;
        }
        p{
            font-family: arial, sans-serif;
            padding: 5px 0;
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
        .rslides_tabs{
            text-align: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .rslides_tabs li{
            display: inline;
        }
        .rslides_tabs li a{
            display: inline-block;
            margin: 5px 3px;
            font-size: 0;
            color: #fff;
            border: 1px solid #808080;
            border-radius: 10px;
            height: 10px;
            width: 10px;
        }
        .rslides_tabs li.rslides_here a{
            background: #808080;
            border-color: #373737;
        }
        .row-slides{
            border: 1px solid #F1F1F1;
            border-radius: 3px;
            width: 600px;
            margin: 10px auto;
        }
        .row-slides img{
            height: 200px;
            width: 100%;
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


    function API_callback(method, result, data){
        console.log(method, result, data);
    }

    /**
     *
     */
    /*$(document).ready(function(){
        var rParams = FAPI.Util.getRequestParameters();
        FAPI.init(rParams["api_server"], rParams["apiconnection"],
            function() {
                //alert("Инициализация прошла успешно");
                FAPI.UI.postMediatopic({
                    media:[
                        {
                            type: 'text',
                            text: ''
                        },
                        {
                            type: 'link',
                            url: ''
                        }
                    ]
                }, false);

            },
            function(error) {
                //alert("Ошибка инициализации");
            }
        );
    });*/

    function completeQuest(post_id, visitor_uid, vendor_code){
        $.ajax({
            url: '/connect/success',
            dataType: 'json',
            type: 'get',
            data: {
                post_id: post_id,
                visitor_uid: visitor_uid,
                vendor_code: vendor_code,
                token: '<?= $quest_token ?>'
            },
            success: function(data){
                alert('Скидка получена');
            }
        });
    }

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
                    completeQuest(post_id, visitor_uid, 'VK');
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
        FB.login(function(auth_response) {
            console.log(auth_response);
            FB.api(
                "/me/feed",
                "POST",
                {
                    message: '<?= $text ?>',
                    link: '<?= $href ?>',
                    picture: 'http://www.ferra.ru/580x600/images/331/331936.jpg',
                    name: 'Заголовок сообщения',
                    caption: 'дополнительный текст',
                    description: '<?= $text ?>'
                },
                function (response) {
                    console.log(response);
                    if (response && !response.error) {
                        // TODO: error message
                        return;
                    }
                    completeQuest(response.id, auth_response.authResponse.userID, 'FB');
                }
            );

        }, {scope: 'publish_actions,publish_stream,publish_actions'});
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

    <div class="row-slides">
        <ul class="rslides">
            <li><img src="/i/vk-1.jpg" alt=""></li>
            <li><img src="/i/vk-2.jpg" alt=""></li>
            <li><img src="/i/vk-3.jpg" alt=""></li>
            <li><img src="/i/fb-1.jpg" alt=""></li>
            <li><img src="/i/fb-2.jpg" alt=""></li>
        </ul>
        <script>
            $(function() {
                $(".rslides").responsiveSlides({
                    pager: true
                });
            });
        </script>
    </div>

    <div class="row-ico" style="width: ">
        <div class="col-ico"><a href="#"><img src="/packages/socico/vk-128.png" alt="" onclick="doVk(); return false;"></a></div>
        <!--div class="col-ico"><a href="#"><img src="/packages/socico/ok-128.png" alt="" onclick="doOk(); return false;"></a></div-->
        <div class="col-ico"><a href="#"><img src="/packages/socico/fb-128.png" alt="" onclick="doFb(); return false;"></a></div>
    </div>
</div>
</body>
</html>