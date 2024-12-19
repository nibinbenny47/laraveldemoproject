<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funding extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'campus_id', 'fees'];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function additionalDetails(){
        return $this->hasMany(AdditionalDetail::class);
    }
    public function campus()
    {
        return $this->belongsTo(campus::class);
    }
}
