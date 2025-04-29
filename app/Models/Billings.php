<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billings extends Model
{
    protected $fillable = ['menu_id', 'final_price'];

    protected $casts = [
        'menu_id' => 'array',
    ];
}
