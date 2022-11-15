<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'mdblms_subjects';
    public $timestamps = false;

    public function getChapter()
    {
        return $this->belongsTo('App\Models\Chapter','subject_id','id')->select(['id', 'chapter_name','chapter_id'])->where('is_active',1);
    }
}
