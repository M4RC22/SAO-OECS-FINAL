<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalCoorganizer extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
