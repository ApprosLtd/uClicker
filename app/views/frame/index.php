<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Скидочный сервис uClicker</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<script type="text/javascript">

    VK.init({
        apiId: 4335971
    });

    function doVk(){
        VK.Auth.login(function(data){
            
            console.log(data);
            
            var visitor_id = 0;
            
            if (data.session && data.session.user && data.session.user.id) {
                visitor_id = data.session.user.id;
            }

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
                            visitor_id: visitor_id,
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

</script>

<h1>Данное окно нужно для обработки ))</h1>

<a href="#" onclick="doVk(); return false;">Получить скидку за лайк в ВК</a>

</body>
</html>