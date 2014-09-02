function UCL(){
    this.winObj = null;

    this.winName = 'WinUCL';
}
UCL.prototype.linck = function(title, text, href, image){
    var url = 'http://uclicker.ru/connect/frame?title='+title+'&text='+text+'&href='+href+'&image='+image;

    var w = 800;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);

    this.winObj = window.open(url, this.winName, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

    window.addEventListener('message', function(event) {
        console.log(event);
    }, false);
}
UCL.prototype.callDone = function(data){
    alert(data);
}

window.UCL = new UCL();