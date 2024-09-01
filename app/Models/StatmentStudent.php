<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatmentStudent extends Model
{
    use HasFactory;

    protected $table = 'statement_student';

    public $timestamps = false;

    protected $fillable = [
        'id_statement',
        'id_stud',
        'ocenka',
        'ocenka_exam'
    ];

}
