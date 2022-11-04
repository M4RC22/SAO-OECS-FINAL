<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory;
    use Uuid;

    protected $guarded = ['id'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function getOrganizerInfo(){
        return $this->belongsTo(OrganizationUser::class,  'organizer_organization_user_id', 'id');
    }



    // PROPOSAL CHILD FORMS
    public function preprograms()
    {
        return $this->hasMany(PrePrograms::class);
    }
    public function logisticalNeed()
    {
        return $this->hasMany(LogisticalNeed::class);
    }
    public function externalCoorganizer()
    {
        return $this->hasMany(ExternalCoorganizer::class);
    }

    public function classification($actClassification){
        if($actClassification === 't1'){
            return 'CSR/Community Service';
        }elseif($actClassification === 't2'){
            return 'Games/Competition';
        }elseif($actClassification === 't3'){
            return 'Marketing';
        }elseif($actClassification === 't4'){
            return 'Social Event/Party/Celebration';
        }elseif($actClassification === 't5'){
            return 'Workshop/Seminar/Training/Symposium/Forum/Team Building';
        }

    }
}
