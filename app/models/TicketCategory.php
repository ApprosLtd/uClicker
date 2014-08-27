<?php

class TicketCategory extends CrudModel
{
    public $table = 'tickets_categories';

    public $timestamps = false;

    protected $fillable = ['title'];
    
}