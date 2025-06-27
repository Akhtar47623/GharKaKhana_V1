<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PickupDelivery extends Model
{
    use SoftDeletes;
    protected $table = "pickup_delivery";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public function pickupDetails()
    {
        return $this->hasOne('App\Model\PickupDetails','pickup_delivery_id','id');      
              
    }
    public function deliveryDetails()
    {
        return $this->hasMany('App\Model\DeliveryDetails','pickup_delivery_id','id');
    }
    
}