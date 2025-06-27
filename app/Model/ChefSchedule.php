<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChefSchedule extends Model
{
   
    protected $table = "chef_schedule";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
