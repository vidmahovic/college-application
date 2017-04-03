<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model // OBCINA
{
    protected $table = 'districts';

    protected $fillable = ['id', 'name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];
}