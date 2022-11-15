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

    public function getSubject()
    {
        return $this->hasOne('App\Models\Subject','id','subject_id')->select(['id', 'subject_name','subject_id'])->where('is_active',1);
    }
}
