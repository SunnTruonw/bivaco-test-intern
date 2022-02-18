<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = "lessons";
    protected $primaryKey = 'id';
    protected $guarded = [];
}
