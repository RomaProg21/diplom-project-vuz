<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use HasFactory;

    protected $table = 'statement';

    public $timestamps = false;

    protected $fillable = [
        'vidkontr_id',
        'predmet_id',
        'prepod_id',
        'date',
        'nomdok',
        'id_groupstud',
        'kurs'
    ];

}
