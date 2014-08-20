<script type="text/javascript" src="/packages/handlebars/handlebars-v1.3.0.js"></script>

<link rel="stylesheet" href="/packages/gridman/gridman.css">
<script type="text/javascript" src="/packages/gridman/jquery.gridman.js"></script>

<div class="row">
    <div class="col-md-9"><h3 style="margin: 3px 0 0;">{{ $title or '' }}</h3></div>
</div>

<script>
    function saveEditForm(grid){
        var commonModal = $('#common-modal');
        var parent = $(this).parents('.modal-content')[0];
        var titleField  = $(parent).find('input[name="title"]');
        var title = titleField.val();
        var colorField  = $(parent).find('input[name="color"]');
        var color = colorField.val();
        var error = false;
        if (title == '') {
            titleField.parents('.form-group').addClass('has-error');
            error = true;
        }
        if (color == '') {
            colorField.parents('.form-group').addClass('has-error');
            error = true;
        }
        if (error) return;
        grid.saveRecord({
            title: title,
            color: color
        }, function(){
            commonModal.modal('hide');
        });
    }
    function onPressAddingBtn(grid){
        var commonModal = $('#common-modal');
        var source = $('#').html();
        commonModal.find('div.modal-body').html(Handlebars.compile(source));
        commonModal.find('.modal-button-save').unbind('click').on('click', function(){
            saveEditForm(grid);
        });
        commonModal.modal('show');

        var colorField = commonModal.find('input[name="color"]');
        if (colorField.length > 0) {
            colorField.minicolors({
                opacity: false,
                inline: false,
                defaultValue: '#c92424'
            });
        }
    }
    function onPressEditBtn(grid, index){
        var commonModal = $('#common-modal');
        var source = $('#').html();
        commonModal.find('div.modal-body').html(Handlebars.compile(source));
        commonModal.find('.modal-button-save').unbind('click').on('click', function(){
            saveEditForm(grid);
        });
        commonModal.modal('show');

        var colorField = commonModal.find('input[name="color"]');
        if (colorField.length > 0) {
            colorField.minicolors({
                opacity: false,
                inline: false,
                defaultValue: '#c92424'
            });
        }
    }
    var gridman = null;
    $(document).ready(function(){
        gridman = $('#merchants-data-table').gridman({
            controller: '/admin/rest/merchants',
            model: 'merchants',
            actions: 'edit|delete',
            columns: [{
                title: 'ИД',
                key: 'id'
            },{
                title: 'Email',
                key: 'email'
            },{
                title: 'Баланс',
                key: 'balance'
            }],
            events: {
                onPressAddingBtn: onPressAddingBtn,
                onPressRowButtonEdit: onPressEditBtn
            }
        });
    });
</script>

<div style="height: 30px"></div>

<table class="table" id="merchants-data-table">
    <!-- grid -->
</table>