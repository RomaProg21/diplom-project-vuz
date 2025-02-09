<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predmet extends Model
{
    use HasFactory;

    protected $table = 'predmet';

    public $timestamps = false;

    protected $fillable = [
        'prepod_id',
        'name',
        'clock'
    ];

}
