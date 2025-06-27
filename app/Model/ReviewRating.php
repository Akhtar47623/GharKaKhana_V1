<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ReviewRating extends Model
{
    use SoftDeletes;
    protected $table = "review_rating";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    const OPEN = '0';
    const SKIP = '1';
    const COMPLETE = '2';
    
    public function user()
    {
        return $this->hasOne('App\Model\Users','id','chef_id')->select('id', 'display_name','profile');
    }
    
}