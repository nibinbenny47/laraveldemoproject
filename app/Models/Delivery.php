<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
