<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicVideo extends Model
{
    use HasFactory;
    protected $table = 'mdb_topic_videos';
    public $timestamps = false;
}
