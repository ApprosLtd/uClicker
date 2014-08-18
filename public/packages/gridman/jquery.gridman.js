(function( $ ){

    function Gridman(element, config){

        this.el = $(element);

        this.cfg = $.extend({
            autoLoad: true,
            columns: []
        }, config);

        this.body = this.el.find('tbody');

        this.data = [];

        //this.columns = this.el.data('columns').split(',');

        this.source_name = this.el.data('source');

        this.prepareGrid();

        this.bodyUpdate();

        var self = this;

        this.el.find('.act-body-update').on('click', function(){
            self.bodyUpdate();
        });
    }
    Gridman.prototype.read = function(){
        //
    }
    Gridman.prototype.write = function(){
        //
    }
    Gridman.prototype.destroy = function(){
        //
    }
    Gridman.prototype.load = function(data, success){
        this.ajax({
            data: data,
            success: success
        });
    }
    Gridman.prototype.ajax = function(data){
        $.ajax($.extend({
            url: this.cfg.controller,
            type: 'get',
            dataType: 'json'
        }, data));
    }
    Gridman.prototype.prepareColumn = function(params){

        return '<th>'+params.title+'</th>';
    }
    Gridman.prototype.prepareGrid = function(){
        var columnsContent = '',
            footerContent  = '';

        if (this.cfg.columns.length > 0) {
            for (var colIndex = 0; colIndex < this.cfg.columns.length; colIndex++) {
                columnsContent += this.prepareColumn(this.cfg.columns[colIndex]);
            }
        }

        this.el.append('<thead></thead>');
        this.head = this.el.find('thead');
        this.head.html('<tr>'+columnsContent+'</tr>');

        this.el.append('<tbody></tbody>');
        this.body = this.el.find('tbody');
        //this.body.html('<tr><td></td></tr>');

        this.el.append('<tfoot></tfoot>');
        this.foot = this.el.find('tfoot');
        this.foot.html('<tr><td>'+footerContent+'</td></tr>');

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
        this.each(function() {
            new Gridman(this, config);
        });
    };
})(jQuery);