<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationUser extends Pivot
{
    use HasFactory;
    use Uuid;

    protected $guarded = [
        'id'
    ];
    
    //Pivot table organization_user
    protected $table = 'organization_user';
    

    // BELONGS TO
    public function fromUser(){
        return $this->belongsTo(User::class, 'user_id');
    }



    // HAS
    public function toForm(){
        return $this->hasMany(Form::class, 'prep_by', 'user_id');
    }


    public function toProposal(){
        return $this->hasMany(Proposal::class, 'organizer_organization_user_id');
    }


    public function getOrgName(){
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
