(function( $ ){
    function Gridman(element, config){

        this.el = $(element);

        this.cfg = $.extend({
            autoLoad: true,
            columns: [],
            actions: []
        }, config);

        this.actions = this.cfg.actions.split('|');
        this.data = {
            limit: 5,
            offset: 0,
            model: this.cfg.model
        };

        this.body    = this.el.find('tbody');
        this.columns = this.cfg.columns;

        this.prepareGrid();
        this.bodyUpdate();
    }
    Gridman.prototype.getData = function(field){
        if (field) {
            if (this.data[field]) {
                return this.data[field]
            } else {
                return null;
            }
        }
        return this.data;
    }
    Gridman.prototype.read = function(){
        //
    }
    Gridman.prototype.write = function(rec, success){
        this.ajax({
            type: 'POST',
            data: {
                model: this.cfg.model,
                fields: rec
            },
            success: success
        });
    }
    Gridman.prototype.destroy = function(index, success){
        var self = this;
        this.ajax({
            url: this.cfg.controller + '/' + index,
            type: 'DELETE',
            data: {model: this.getData('model')},
            success: function(){
                self.bodyUpdate();
            }
        });
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
    Gridman.prototype.saveRecord = function(record, success){
        var self = this;
        this.write(record, function(response){
            self.bodyUpdate();
            if (success) success();
        });
    }
    Gridman.prototype.addRecord = function(record){
        var rowContent = $('<tr></tr>');
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
            var vtd = $('<td></td>');
            vtd.append(value);
            rowContent.append(vtd);
        }
        var actionsButtons = this.getActionsButtons(record.id);
        if (actionsButtons) {
            var atd = $('<td style="text-align: right;"></td>');
            atd.append(actionsButtons);
            rowContent.append(atd);
        }
        this.body.append(rowContent);
    }
    Gridman.prototype.addRecords = function(recordsArr){
        for (var recIndex = 0; recIndex < recordsArr.length; recIndex++) {
            this.addRecord(recordsArr[recIndex]);
        }
    }
    Gridman.prototype.ajax = function(data){
        $.ajax($.extend({
            url: this.cfg.controller,
            type: 'GET',
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
        this.prepareActions();

        this.el.append('<tbody></tbody>');
        this.body = this.el.find('tbody');

        this.el.append('<tfoot></tfoot>');
        this.foot = this.el.find('tfoot');
        this.foot.html('<tr><td colspan="'+this.getColspan()+'">'+footerContent+'</td></tr>');
        this.prepareFooterButtons();
        this.attachFooterEvents();

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
        var colspan = this.columns.length;
        if (this.actions.length > 0) colspan++;
        return colspan;
    }
    Gridman.prototype.bodyUpdate = function(){
        var self = this;
        self.showBodyPreloader();
        this.load(self.getData(), function(response){
            if (response.data && response.data.length > 0) {
                self.clearBoby();
                self.addRecords(response.data);
            } else {
                self.setBodyInfo('<div style="text-align: center"><em>Нет данных для отобрадения</em></div>');
            }
            if (response.total) {
                self.el.find('.statusbar-total').html(response.total);
                var data = self.getData();
                var from = data.offset + 1;
                var to   = data.offset + data.limit;
                if (to > response.total) to = response.total;
                self.el.find('.statusbar-from').html(from);
                self.el.find('.statusbar-to').html(to);
            }
        });
    }
    Gridman.prototype.getFooterContent = function(){

        var content =  '<div class="row">'
                     + '  <div class="col-md-5">'
                     + '    <button type="button" name="button-adding" class="btn btn-sm btn-primary">Добавить</button>'
                     + '    <button type="button" name="button-reload" class="btn btn-sm btn-default act-body-update" title="Обновить"><span class="glyphicon glyphicon-refresh"></span></button>'
                     + '  </div>'
                     + '  <div class="col-md-2">'
                     + '    <div class="input-group input-group-sm">'
                     + '        <div class="input-group-btn">'
                     + '            <button type="button" name="button-tofirst" class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-fast-backward"></span></button>'
                     + '            <button type="button" name="button-previous" class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-chevron-left"></span></button>'
                     + '        </div>'
                     + '        <input type="text" class="form-control" style="text-align: center; font-weight: bold;" value="1" disabled="disabled">'
                     + '        <div class="input-group-btn">'
                     + '            <button type="button" name="button-following" class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-chevron-right"></span></button>'
                     + '            <button type="button" name="button-tolast" class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-fast-forward"></span></button>'
                     + '        </div>'
                     + '    </div>'
                     + '  </div>'
                     + '  <div class="col-md-5" style="text-align: right">Загружено с <span class="statusbar-from"></span> по <span class="statusbar-to"></span> из <span class="statusbar-total"></span></div>'
                     + '</div>';
        
        return content;
    }
    Gridman.prototype.prepareFooterButtons = function(){
        this.foot.buttons = {
            adding: this.el.find('tfoot button[name="button-adding"]'),
            reload: this.el.find('tfoot button[name="button-reload"]'),
            toFirst: this.el.find('tfoot button[name="button-tofirst"]'),
            previous: this.el.find('tfoot button[name="button-previous"]'),
            following: this.el.find('tfoot button[name="button-following"]'),
            toLast: this.el.find('tfoot button[name="button-tolast"]')
        }
    }
    Gridman.prototype.attachFooterEvents = function(){
        var self = this;
        this.foot.buttons.adding.on('click', function(){
            self.fireEvent('onPressAddingBtn');
        });
        this.foot.buttons.reload.on('click', function(){
            self.fireEvent('beforeBodyUpdate');
            self.bodyUpdate();
            self.fireEvent('afterBodyUpdate');
        });
    }
    Gridman.prototype.fireEvent = function(eventName, params){
        if (!this.cfg.events) return;
        if (!this.cfg.events[eventName]) return;
        this.cfg.events[eventName](this, params);
    }
    Gridman.prototype.prepareActions = function(){
        if (this.actions.length < 1) return;
        this.head.find('tr').append('<th style="width: '+(this.actions.length*40)+'px"></th>');
    }
    Gridman.prototype.getActionsButtons = function(index){
        if (this.actions.length < 1) return null;
        var self = this;
        var btnGroup = $('<div class="btn-group btn-group-xs"></div>');
        for (var btnIndex = 0; btnIndex < this.actions.length; btnIndex++) {
            var btn = null;
            switch (this.actions[btnIndex]) {
                case 'view':
                    btn = $('<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span></button>');
                    btn.on('click', function(){
                        self.fireEvent('onPressRowButtonView', index);
                    });
                    break;
                case 'edit':
                    btn = $('<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button>');
                    btn.on('click', function(){
                        self.fireEvent('onPressRowButtonEdit', index);
                    });
                    break;
                case 'delete':
                    btn = $('<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>');
                    btn.on('click', function(){
                        self.destroy(index);
                    });
                    break;
            }
            if (btn) btn.appendTo(btnGroup);
        }
        return btnGroup;
    }

    $.fn.gridman = function(config) {
        var gridman = null;
        this.each(function() {
            gridman = new Gridman(this, config);
        });
        return gridman;
    };
})(jQuery);