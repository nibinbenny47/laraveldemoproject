<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'campus_id', 'start_date', 'card_img', 'category'];

    public function campus()
    {
        return $this->belongsTo(campus::class);
    }
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
    public function career(){
        return $this->hasMany(Career::class);
    }
}
