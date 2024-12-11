<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalDetail extends Model
{
    use HasFactory;
    protected $fillable = ['funding_id', 'details'];
    public function funding()
    {
        return $this->belongsTo(Funding::class);
    }
}
