<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Untitled</title>
</head>
<body>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<script type="text/javascript">

    VK.init({
        apiId: 4335971
    });

    function doVk(){
        VK.Auth.login(function(data){

            VK.Api.call('wall.post', {
                message: '<?= $text ?>',
                attachments: '<?= $href ?>'
            }, function(data) {

                var post_id = 0;

                if (data.response && data.response.post_id) {
                    post_id = data.response.post_id;
                }

                console.log(data);
                window.opener.postMessage('ucl_message:post_id:' + post_id, '*');
            });

        }, 8192);
    }

</script>

<h1>Данное окно нужно для обработки ))</h1>

<a href="#" onclick="doVk(); return false;">Получить скидку за лайк в ВК</a>

</body>
</html>