<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Untitled</title>
</head>
<body>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<script type="text/javascript">

    //var url = 'http://vk.com/al_apps.php?act=wall_post_box&widget=1&method=wall.post&aid=4335971&text=<?= $text ?>&attachments=<?= $href ?>';

    //window.location = url;


    VK.init({
        apiId: 4335971
    });

    //VK.Auth.logout();

    VK.Auth.login(function(data){

        VK.Api.call('wall.post', {
            message: '<?= $text ?>',
            attachments: '<?= $href ?>'
        }, window.top.window.UCL.prototype.callDone);

    }, 8192);

    VK.Auth.getLoginStatus(function(status){

        //var url = 'http://vk.com/al_apps.php?act=wall_post_box&widget=1&method=wall.post&aid=4335971&text=<?= $text ?>&attachments=<?= $href ?>';

        //window.location = url;



    });



</script>

</body>
</html>