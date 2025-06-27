<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Group extends Model
{
    use SoftDeletes;
    protected $table = "menu_option_group";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
