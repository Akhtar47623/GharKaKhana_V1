<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tax extends Model
{
    use SoftDeletes;
    protected $table = "chef_tax";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
