<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_assignment extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'mdb_course_assignment';
    public $timestamps = false;
     protected $fillable = [
        'user_id',
        'course_id',
        'added_by',
        'added_datetime',
        'course_start_date',
        'is_active'
    ];

   
}
