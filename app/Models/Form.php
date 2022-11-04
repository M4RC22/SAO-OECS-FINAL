<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Form extends Model
{
    use HasFactory;
    use Uuid;

    protected $guarded = ['id'];

    public function proposal()
    {
        return $this->hasOne(Proposal::class);
    }

    public function liquidation(){
        return $this->hasOne(Liquidation::class);
    }

    public function narrative()
    {
        return $this->hasOne(Narrative::class);
    }

    public function requisition()
    {
        return $this->hasOne(Requisition::class);
    }

    public function fromOrgUser(){
        return $this->belongsTo(OrganizationUser::class, 'prep_by', 'user_id');
    }

    public function myOrg(){
        return $this->belongsTo(OrganizationUser::class, 'organization_id', 'organization_id');
    }

    public function getSao(){
        return $this->belongsTo(Staff::class, 'sao_staff_id');
    }

    public function getOrganizerInfo(){
        return $this->belongsTo(OrganizationUser::class, 'organizer_organization_user_id', 'id');
    }




    // For PDF

    public function getFormAdviser()
    {
        return $this->belongsTo(OrganizationUser::class, 'organization_user_adviser_id'); 
    }

    public function getFormSao()
    {
        return $this->belongsTo(Staff::class, 'sao_staff_id'); 
    }

    public function getFormAcadserv()
    {
        return $this->belongsTo(Staff::class, 'acadserv_staff_id'); 
    }

    public function getFormFinance()
    {
        return $this->belongsTo(Staff::class, 'finance_staff_id'); 
    }
}


