<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    use HasFactory;

    protected $table = 'group_students';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'id_fakultet',
        'kurs'
    ];

}
