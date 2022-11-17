<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCQ extends Model
{
    use HasFactory;
    protected $table = 'mdblms_mcq';
    public $timestamps = false;
}
