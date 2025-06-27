<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Nutrition extends Model
{
    use SoftDeletes;
    protected $table = "menu_nutrition";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

}