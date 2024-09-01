<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Online extends Model
{
    use HasFactory;

    protected $table = 'online';

    public $timestamps = false;

    protected $fillable = [
        'predmet_id',
        'group_id',
        'link',
        'date'
    ];

}
