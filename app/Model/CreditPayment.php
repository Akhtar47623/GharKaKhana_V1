<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CreditPayment extends Model
{
    use SoftDeletes;
    protected $table = "credit_payment";
    protected $primaryKey = "id";

    protected $guarded = ['id'];
}