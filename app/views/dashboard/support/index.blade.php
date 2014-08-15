<? if (!isset($is_empty) or $is_empty == false) { ?>
    
<div class="row" style="padding: 50px 0; text-align: center;">
  <div class="col-md-12">
      <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalAddTicket">Создать тикет</button>
  </div>
</div>
    
<? } else { ?>
<script src="/packages/widget/grid.js"></script>

<div class="row" style="padding: 20px 0; margin-top: -15px; border-radius: 5px 5px 0 0; border-bottom: 1px solid #E6E6E6;">
  <div class="col-md-6">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddTicket">Создать тикет</button>
  </div>
</div>

<div class="row" style="border-bottom: 1px solid #DFDFDF; margin-bottom: 20px; padding: 20px 0; background: #F5F5F5">
    <div class="col-md-12">
<?
echo \Widget\Grid::controls(array(
    'target'    => 'tickets',
    'container' => "#tickets-list-container"
));
?>
    </div>
</div>

<div id="tickets-list-container"></div>

<script>
function hookColumnRendererTickets(data){

    var output  = '<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid #DFDFDF;">';
        output += '  <div class="col-md-12"><a href="#"><h4 style="margin: 0 0 10px">'+data.title+'</h4></a></div>';
        output += '  <div class="col-md-5"><strong>'+data.category_title+'</strong></div><div class="col-md-2">'+data.status+'</div><div class="col-md-2"><span class="label label-success" style="background-color: '+data.priority_color+'">'+data.priority_title+'</span></div>';
        output += '  <div class="col-md-12" style="padding-top: 20px;"><blockquote><p>'+data.content+'</p><footer>'+data.created_at+'</footer></blockquote></div>';
        output += '  <div class="col-md-12"><blockquote class="blockquote-reverse"><p>'+data.content+'</p><footer>'+data.created_at+'</footer></blockquote></div>';
        output += '</div>';

    return output;
}
loadGridData({
    from: 0,
    to: 0,
    target: 'tickets',
    page: 1,
    container: '#tickets-list-container'
});
</script>
<? } ?>

<div class="modal fade" id="modalAddTicket" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                <h4 class="modal-title">Новый тикет</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form">
                    <input type="hidden" id="site-id" value="0">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Заголовок" id="ticket-title">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <span style="padding-right: 5px;">Приоритет:</span>
                            <input type="hidden" id="ticket-priority">
                            <div class="btn-group" data-toggle="buttons">
                            @foreach ( \TicketPriority::all() as $ticket_priority )
                                <label class="btn btn-default btn-sm" name="ticket-priority" style="background-color: {{ $ticket_priority->color }}">
                                    <input type="radio" value="{{ $ticket_priority->id }}">{{ $ticket_priority->title }}
                                </label>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <span style="padding-right: 5px;">Категория:</span>
                            <select id="ticket-category">
                                <option>- - -</option> 
                            @foreach (\TicketCategory::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>                            
                            @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="5" placeholder="Сообщение" id="ticket-content"></textarea>
                        </div>
                    </div>
                    <p><em>Все поля обязательны для заполнения</em></p>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="ticketSave()" id="site-button-save">Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="formClear()">Отмена</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('[name="ticket-priority"]').on('click', function(){
        $('#ticket-priority').val( $(this).find('input').val() );
    });
});
function ticketSave(){
    var title    = $('#ticket-title').val(),
        priority = $('#ticket-priority').val(),
        category = $('#ticket-category').val(),
        content  = $('#ticket-content').val();
        
    var error = false;
        
    if (title == '') {
        //
        error = true;
    }    
    if (priority <= 0) {
        //
        error = true;
    }    
    if (category <= 0) {
        //
        error = true;
    }    
    if (content == '') {
        //
        error = true;
    }
    
    if (error) return;
    
    $.ajax({
        url: '/support/add-ticket',
        dataType: 'json',
        type: 'post',
        data: {
            title:    title,
            priority: priority,
            category: category,
            content:  content,
        },
        success: function(data) {
            window.location = window.location;
        }
    });
}
</script>