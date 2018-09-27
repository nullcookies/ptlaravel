<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SProduct extends Model
{
    protected $table = 'sproduct';
    protected  $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

}
