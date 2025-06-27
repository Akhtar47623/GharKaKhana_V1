<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PickupDetails extends Model
{
    use SoftDeletes;
    protected $table = "pickup_details";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    
}