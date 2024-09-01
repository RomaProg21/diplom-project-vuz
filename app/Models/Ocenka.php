<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocenka extends Model
{
    use HasFactory;

    protected $table = 'ocenka';

    public $timestamps = false;

    protected $fillable = [
        'stud_id',
        'predmet_id',
        'ocenka',
        'date',
        'group_id',
        'module'
    ];

}
