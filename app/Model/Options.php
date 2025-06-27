<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Options extends Model
{
    use SoftDeletes;
    protected $table = "menu_options";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public function group()
    {
        return $this->belongsTo('App\Model\Group','group_id','id');
    }
    
}
