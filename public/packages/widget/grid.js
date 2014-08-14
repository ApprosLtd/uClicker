$(document).ready(function(){
    $('.grid-datepicker').datepicker({
        dateFormat: 'dd.mm.yy',
        changeMonth: true,
        changeYear: true,
        onSelect: function(dateText, inst){
            var target = $(inst.input[0]).data('target');
            var fromDateStr, toDateStr;
            target = target.split('-');
            var dr = target[1];
            target = target[0];
            if (dr=='from') {
                fromDateStr = dateText;
                toDateStr   = $('input[data-target="'+target+'-to"]').val();
            } else if (dr=='to') {
                fromDateStr = $('input[data-target="'+target+'-from"]').val();
                toDateStr   = dateText;
            }
            loadGridData(fromDateStr, toDateStr, target);
        }
    });

    $('.pagination a').on('click', function(){

        var parent = $(this).parents('.pagination');
        if (parent.length < 1) return false;

        parent = $(parent[0]);

        var target = parent.data('target');
        var fromDatepicker = $('[data-target="'+target+'-from"]');
        var toDatepicker   = $('[data-target="'+target+'-to"]');

        loadGridData(fromDatepicker.val(), toDatepicker.val(), target, $(this).text());

        return false;
    });

    $('[data-period]').on('click', function(){
        var target   = $(this).data('target');
        var currentDate = new Date();

        var fromDate = new Date();

        switch ($(this).data('period')) {
            case 'today':
                fromDate = new Date();
                break;
            case 'yesterday':
                fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()-1);
                break;
            case 'week':
                fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()-7);
                break;
            case 'month':
                fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth()-1, currentDate.getDate());
                break;
            case 'quarter':
                fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth()-3, currentDate.getDate());
                break;
            case 'year':
                fromDate = new Date(currentDate.getFullYear()-1, currentDate.getMonth(), currentDate.getDate());
                break;
        }

        var fromDateMonth = fromDate.getMonth()+1;
        if (fromDateMonth < 10) fromDateMonth = '0' + fromDateMonth;
        var toDateMonth   = currentDate.getMonth()+1;
        if (toDateMonth < 10) toDateMonth = '0' + toDateMonth;

        var fromDateStr = fromDate.getDate()+'.'+fromDateMonth+'.'+fromDate.getFullYear();
        var toDateStr   = currentDate.getDate()+'.'+toDateMonth+'.'+currentDate.getFullYear();

        var fromDatepicker = $('[data-target="'+target+'-from"]');
        var toDatepicker   = $('[data-target="'+target+'-to"]');

        fromDatepicker.datepicker('setDate', fromDateStr);
        toDatepicker.datepicker('setDate', toDateStr);

        loadGridData(fromDatepicker.val(), toDatepicker.val(), target);
    });
});

function loadGridData(from, to, target, page){
    var grid = $('table[data-target="'+target+'"]');
    var columns = grid.data('columns').split(',');
    var emptyRow = grid.find('tbody td.empty-row em');
    emptyRow.text('Загрузка данных...');
    if (!page) page = 1;
    $.ajax({
        url: '/data',
        dataType: 'json',
        type: 'post',
        data: {
            from_date: from,
            to_date: to,
            target: target,
            page: page
        },
        success: function(data){
            var trOutput = '';
            if (data.rows && data.rows.length > 0) {
                trOutput = '';
                for (var rid; rid < data.rows.length; rid++) {
                    trOutput += '<tr>';
                    for (var cid; cid < columns.length; cid++) {
                        trOutput += '<td>'+data.rows[rid][columns[cid]]+'</td>';
                    }
                    trOutput += '</tr>';
                }
                grid.find('tbody').html(trOutput);
            } else {
                emptyRow.text('Нет данных для отображения');
            }
        }
    });
}