<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentDetails extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
