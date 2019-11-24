<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class imamzade_temp extends Model
{
    protected $fillable = [
        'imamzade_Name','Ancestor','Address', 'latitude', 'longitude','PID','CID','UID',
    ];
}
