<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultet extends Model
{
    use HasFactory;

    protected $table = 'fakultet';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

}
