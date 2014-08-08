<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Untitled</title>
</head>
<body>
<!--script src="//vk.com/js/api/openapi.js" type="text/javascript"></script-->
<script type="text/javascript">


    var url = 'http://vk.com/al_apps.php?act=wall_post_box&widget=1&method=wall.post&aid=4335971&text=<?= $text ?>&attachments=<?= $href ?>';

    window.location = url;

    //window.addEventListener();

    /*
    VK.init({
        apiId: 4335971
    });

    VK.Auth.logout();

    VK.Auth.login(function(data){
        console.log(data);
    }, 8192);

    VK.Auth.getLoginStatus(function(status){

        var url = 'http://vk.com/al_apps.php?act=wall_post_box&widget=1&method=wall.post&aid=4335971&text=<?= $text ?>&attachments=<?= $href ?>';

        window.location = url;


        VK.Api.call('wall.post', {
            message: '<?= $text ?>',
            attachments: '<?= $href ?>'
        }, function(data) {
            console.log(data);
        });
    });

    */

</script>

</body>
</html>