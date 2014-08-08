function UCL(){
    this.winObj = null;

    this.winName = 'WinUCL';
}
UCL.prototype.linck = function(text, href){
    var url = 'http://weber.appros.ru/frame?text='+text+'&href='+href;

    var w = 800;
    var h = 500;
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