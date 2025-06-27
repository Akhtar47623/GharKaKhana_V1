<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Cuisine extends Model
{
    use SoftDeletes;
    protected $table = "cuisine";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
