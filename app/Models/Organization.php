<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    use Uuid;

    protected $guarded = ['id'];

    public function studentOrg()
    {
        return $this->belongsToMany(User::class, 'organization_user', 'organization_id', 'user_id')
        ->withPivot(['position'])
        ->withPivot(['role'])
        ->withTimestamps();
    }

    public function orgForms(){
        return $this->hasMany(Form::class, 'organization_id');
    }



}
