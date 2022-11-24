<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $table = 'mdblms_topics';
    public $timestamps = false;

    public function getChapter()
    {
        return $this->hasOne('App\Models\Chapter','id','chapter_id')->select(['id', 'chapter_name']);
    }
}
