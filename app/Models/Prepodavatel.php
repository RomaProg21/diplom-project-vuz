<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prepodavatel extends Model
{
    use HasFactory;

    protected $table = 'prepodavatel';

    public $timestamps = false;

    protected $fillable = [
        'fakultet_id',
        'user_id'
    ];

}
