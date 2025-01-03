<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campus extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function fundings()
    {
        return $this->hasMany(Funding::class);
    }
}
