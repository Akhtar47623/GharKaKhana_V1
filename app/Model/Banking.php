<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Banking extends Model
{
    use SoftDeletes;
    protected $table = "chef_banking";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
