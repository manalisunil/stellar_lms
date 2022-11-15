<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicContent extends Model
{
    use HasFactory;
    protected $table = 'mdb_topic_content';
    public $timestamps = false;
}
