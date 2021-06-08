<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calendar extends Model
{
    protected $casts = [
        'date' => 'array',
        'name' => 'array'
    ];
}