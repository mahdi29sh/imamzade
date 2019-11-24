<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class temp_image extends Model
{
    protected $fillable = [
        'TIID'  , 'is_first' , 'image'
    ];
}
