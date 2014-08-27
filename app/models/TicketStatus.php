<?php

class TicketStatus extends Eloquent
{
    protected $table = 'tickets_statuses';

    public $timestamps = false;

    protected $fillable = ['title'];
}
