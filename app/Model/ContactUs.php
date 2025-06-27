<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ContactUs extends Model
{
    use SoftDeletes;
    protected $table = "contact_us";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
    
    
}
