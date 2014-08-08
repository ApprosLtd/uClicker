function UCL(){
    this.winObj = null;

    this.winName = 'WinUCL';
}
UCL.prototype.linck = function(text, href){
    var url = 'http://weber.appros.ru/iframe?text='+text+'&href='+href;
    this.winObj = window.open(url, this.winName, "width=420,height=230,resizable=yes,scrollbars=yes,status=no,location=no,menubar=no");
}

var UCL = new UCL();