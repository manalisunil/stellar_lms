<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectChapterMapping extends Model
{
    use HasFactory;
    protected $table = 'mdblms_subject_chapter_mapping';
    public $timestamps = false;
     protected $fillable = [
        'subject_id',
        'chapter_id',
        'added_by',
        'added_datetime',
        'is_active'
    ];

    public function getSubject()
    {
        return $this->hasOne('App\Models\Subject','id','subject_id')->select(['id', 'subject_name','subject_id'])->where('is_active',1);
    }
}
