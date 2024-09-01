<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SheduleExam extends Model
{
    use HasFactory;

    protected $table = 'schedule_exam';

    public $timestamps = false;

    protected $fillable = [
        'group_id',
        'predmet_id',
        'date',
        'kabinet'
    ];

}
