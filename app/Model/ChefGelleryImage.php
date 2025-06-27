<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class ChefGelleryImage extends Model
{
    protected $table = "chef_gellery";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    
}