<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Categories extends Model
{
    use SoftDeletes;
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    
}