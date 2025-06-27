<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketCategory extends Model
{
    use SoftDeletes;
    protected $table = "ticket_category";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
