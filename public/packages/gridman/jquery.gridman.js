(function( $ ){

    function Gridman(element){

        this.el = $(element);

        this.body = this.el.find('tbody');

        this.data = [];

        this.columns = this.el.data('columns').split(',');

        this.source_name = this.el.data('source');

        this.bodyUpdate();

        var self = this;

        this.el.find('.act-body-update').on('click', function(){
            self.bodyUpdate();
        });
    }
    Gridman.prototype.load = function(data, success){
        $.ajax({
            url: '/gridman',
            type: 'post',
            dataType: 'json',
            data: data,
            success: success
        });
    }
    Gridman.prototype.showBodyPreloader = function(){
        this.setBodyInfo('<p class="gridman-ajax-loader">Загрузка данных</p>');
    }
    Gridman.prototype.hideBodyPreloader = function(){
        this.body.html('');
    }
    Gridman.prototype.setBodyInfo = function(message){
        var colspan =
        this.body.html('<tr><td colspan="3">'+message+'</td></tr>');
    }
    Gridman.prototype.bodyUpdate = function(){
        var self = this;
        self.data = {
            limit: 20,
            offset: 0,
            source: this.source_name
        };
        self.showBodyPreloader();
        this.load(self.data, function(response){
            if (response.data && response.data.length > 0) {
                var rowsContent = '';
                for (var itemIndex = 0; itemIndex < response.data.length; itemIndex++) {
                    rowsContent += '<tr>';
                    for (var columnIndex = 0; columnIndex < self.columns.length; columnIndex++) {
                        var columnKey = self.columns[columnIndex];
                        rowsContent += '<td>'+response.data[itemIndex][columnKey]+'</td>';
                    }
                    rowsContent += '</tr>';
                }
                self.body.html(rowsContent);
            } else {
                self.setBodyInfo('<div style="text-align: center"><em>Нет данных для отобрадения</em></div>');
            }
            if (response.total) {
                self.el.find('.statusbar-total').html(response.total);
            }
        });
    }

    $.fn.gridman = function(config) {
        this.cfg = $.extend({
            auto_load: true
        }, config);
        this.each(function() {
            new Gridman(this);
        });
    };
})(jQuery);