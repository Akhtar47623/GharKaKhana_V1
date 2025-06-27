<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ThirdPartyDetail extends Model
{
    protected $table = "thirdparty_detail";

    protected $primaryKey = "id";

    protected $guarded = ['id'];
}
