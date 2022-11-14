<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSubjectMapping extends Model
{
    use HasFactory;
    protected $table = 'mdblms_course_subject_mapping';
    public $timestamps = false;
     protected $fillable = [
        'subject_id',
        'course_id',
        'added_by',
        'added_datetime',
        'is_active'
    ];
}
