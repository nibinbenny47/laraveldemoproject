<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id','shift', 'subject_name' ];

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
}
