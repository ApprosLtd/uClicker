(function( $ ){

    function Gridman(element, config){

        this.el = $(element);

        this.cfg = $.extend({
            autoLoad: true,
            columns: []
        }, config);

        this.body = this.el.find('tbody');
        
        this.columns = this.cfg.columns;

        this.data = [];

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
    Gridman.prototype.clearBoby = function(){
        this.body.html('');
    }
    Gridman.prototype.addRecord = function(record){
        var rowsContent = '<tr>';
        for (var columnIndex = 0; columnIndex < this.columns.length; columnIndex++) {
            var columnKey = this.columns[columnIndex].key;
            var column = this.columns[columnIndex];
            var value = '';
            if (column.renderer) {
                if (column.key) {
                    value = column.renderer(record[column.key], record);
                } else {
                    value = column.renderer(null, record);
                }
            } else if (column.key) {
                value = record[column.key];
            }
            rowsContent += '<td>'+value+'</td>';
        }
        rowsContent += '</tr>';
        this.body.append(rowsContent);
    }
    Gridman.prototype.addRecords = function(recordsArr){
        for (var recIndex = 0; recIndex < recordsArr.length; recIndex++) {
            this.addRecord(recordsArr[recIndex]);
        }
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
            footerContent  = this.getFooterContent();

        if (this.columns.length > 0) {
            for (var colIndex = 0; colIndex < this.columns.length; colIndex++) {
                columnsContent += this.prepareColumn(this.columns[colIndex]);
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
        this.foot.html('<tr><td colspan="'+this.getColspan()+'">'+footerContent+'</td></tr>');

    }
    Gridman.prototype.showBodyPreloader = function(){
        this.setBodyInfo('<p class="gridman-ajax-loader">Загрузка данных</p>');
    }
    Gridman.prototype.hideBodyPreloader = function(){
        this.body.html('');
    }
    Gridman.prototype.setBodyInfo = function(message){
        this.body.html('<tr><td colspan="'+this.getColspan()+'">'+message+'</td></tr>');
    }
    Gridman.prototype.getColspan = function(){
        return this.columns.length;
    }
    Gridman.prototype.bodyUpdate = function(){
        var self = this;
        self.data = {
            limit: 20,
            offset: 0,
            model: this.cfg.model
        };
        self.showBodyPreloader();
        this.load(self.data, function(response){
            if (response.data && response.data.length > 0) {
                self.clearBoby();
                self.addRecords(response.data);
            } else {
                self.setBodyInfo('<div style="text-align: center"><em>Нет данных для отобрадения</em></div>');
            }
            if (response.total) {
                self.el.find('.statusbar-total').html(response.total);
            }
        });
    }
    Gridman.prototype.getFooterContent = function(){
        var content =  '<div class="row">'
                     + '  <div class="col-md-5">'
                     + '    <button type="button" class="btn btn-sm btn-primary">Добавить</button>'
                     + '    <button type="button" class="btn btn-sm btn-default act-body-update" title="Обновить"><span class="glyphicon glyphicon-retweet"></span></button>'
                     + '  </div>'
                     + '  <div class="col-md-2">'
                     + '    <div class="input-group input-group-sm">'
                     + '        <div class="input-group-btn">'
                     + '            <button type="button" class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-fast-backward"></span></button>'
                     + '            <button type="button" class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-chevron-left"></span></button>'
                     + '        </div>'
                     + '        <input type="text" class="form-control" style="text-align: center; font-weight: bold;" value="1" disabled="disabled">'
                     + '        <div class="input-group-btn">'
                     + '            <button type="button" class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-chevron-right"></span></button>'
                     + '            <button type="button" class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-fast-forward"></span></button>'
                     + '        </div>'
                     + '    </div>'
                     + '  </div>'
                     + '  <div class="col-md-5" style="text-align: right">Загружено с 1 по 10 из <span class="statusbar-total"></span></div>'
                     + '</div>';
        
        return content;
    }

    $.fn.gridman = function(config) {
        this.each(function() {
            new Gridman(this, config);
        });
    };
})(jQuery);