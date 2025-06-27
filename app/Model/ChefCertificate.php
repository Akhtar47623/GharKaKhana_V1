<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ChefCertificate extends Model
{
    use SoftDeletes;
    protected $table = "chef_certification";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

}