function UCL(){
    this.winObj = null;

    this.winName = 'WinUCL';
}
UCL.prototype.linck = function(text, href){
    var url = 'http://weber.appros.ru/frame?text='+text+'&href='+href;
    this.winObj = window.open(url, this.winName, "width=420,height=230,resizable=yes,scrollbars=yes,status=no,location=no,menubar=no");
    this.winObj.addEventListener('click', function(){
        alert('OnBeforeUnload');
    }, false);

    this.winObj.click = onBeforeUnloadGo;

    function onBeforeUnloadGo(){
        alert('Gogo-77');
        console.log('Gogo-77');
    };

}

var UCL = new UCL();