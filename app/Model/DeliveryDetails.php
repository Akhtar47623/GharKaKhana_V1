<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DeliveryDetails extends Model
{
    use SoftDeletes;
    protected $table = "delivery_details";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    
}