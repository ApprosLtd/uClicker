<?php

class TicketMessage extends Eloquent {

    public $table = 'tickets_messages';

    public function ticket()
    {
        return $this->belongsTo('Ticket');
    }

} 