<?php

class Ticket extends Eloquent
{
    public function category()
    {
        return $this->belongsTo('TicketCategory');
    }

    public function priority()
    {
        return $this->belongsTo('TicketPriority');
    }
}