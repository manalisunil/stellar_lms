<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $table = 'mdblms_chapters';
    public $timestamps = false;

    public function getSubject()
    {
        return $this->hasOne('App\Models\Subject','id','subject_id')->select(['id', 'subject_name'])->where('is_active',1);
    }
}
