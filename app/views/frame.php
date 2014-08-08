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

    window.opener.postMessage('foobar', '*');
/*
    VK.Auth.login(function(data){

        VK.Api.call('wall.post', {
            message: '<?= $text ?>',
            attachments: '<?= $href ?>'
        }, function(data) {
            console.log(data);
        });

    }, 8192);*/

</script>

</body>
</html>