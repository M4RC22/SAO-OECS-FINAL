<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Form;
use App\Models\User;
use App\Models\Event;
use App\Models\Staff;
use App\Models\Proposal;
use App\Models\PrePrograms;
use Illuminate\Support\Arr;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\LogisticalNeed;
use App\Mail\apfSubmittedEmail;
use App\Mail\FormApproverEmail;
use App\Models\OrganizationUser;
use App\Http\Requests\APFRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ExternalCoorganizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class APFController extends Controller
{
    // display form
    public function index()
    {
        $authId = auth()->user()->id;

        $authOrgList = Organization::whereHas('studentOrg', function ($query) use ($authId) {
            $query->where('user_id', $authId);
            $query->whereIn('role', ['Moderator', 'Editor']);
        })->get();


        return view('_student-organization.forms.activity-proposal', compact('authOrgList'))
        ->with("message", "Hello APF!");
    }

    // save form
    public function store(APFRequest $request)
    {
        // $validated = $request->validated();
        // dd($validated, $request);
        $proposal = $request->safe()->except(['target_date','org_id','event_title','coorganization', 'coorganizer_name', 'coorganizer_phone', 'coorganizer_email', 'service', 'logistics_date_needed','logistics_venue', 'activity', 'start_date', 'end_date' ]);

        // get ID for approvers
        $orgAdviser = OrganizationUser::where('organization_id',$request->org_id)
            ->where('position', 'Adviser')->first();
         

        //Check first if student organization have an adviser before continuing the process, else return error. 
        if($orgAdviser === null){
            return redirect()->back()->with('error', "Your organization must have an 'Adviser'. Please try again later!");
        }

        $sao = Staff::whereHas('staffDepartment', function($q){
                $q->where('name', '=', 'Student Activities Office');
            })->where('position', 'Head')->pluck('id')->first();

        $acadserv = Staff::whereHas('staffDepartment', function($q){
                $q->where('name', '=', 'Academic Services');
            })->where('position', 'Head')->pluck('id')->first();

        $finance = Staff::whereHas('staffDepartment', function($q){
                $q->where('name', '=', 'Finance Office');
            })->where('position', 'Head')->pluck('id')->first();

        // Form create
        $form = Form::create([
            'event_title' => $request->event_title,
            'organization_id' => $request->org_id,
            'prep_by' => Auth::user()->id,
            'control_number'=> $this->generateUniqueCode(),
            'organization_user_adviser_id' => $orgAdviser->id,
            'sao_staff_id' => $sao,
            'acadserv_staff_id' => $acadserv,
            'finance_staff_id' => $finance,
            'event_id' => $this->generateEventId(),
            'form_type' => 'APF',
            'target_date' => $request->target_date,
            'deadline' => Carbon::now()->setTimezone('Asia/Manila')->addDays(3),
        ]);

        //Proposal Create
        $proposal = $form->proposal()->create($proposal);



        // Logistics create
        for($i = 0; $i < count($request->service); $i++){
            $proposal->logisticalNeed()->create([
                    'service' => $request->service[$i],
                    'date_needed' => $request->logistics_date_needed[$i],
                    'venue' => $request->logistics_venue[$i],
                ]);
        }

         // External Coorg create
         for($i = 0; $i < count($request->coorganization); $i++){
            $proposal->externalCoorganizer()->create([
                    'coorganization' => $request->coorganization[$i],
                    'coorganizer' => $request->coorganizer_name[$i],
                    'email' => $request->coorganizer_email[$i],
                    'phone_number' => $request->coorganizer_phone[$i],
                ]);
        }

        // Pre-programs create
        for($i = 0; $i < count($request->activity); $i++){
            $proposal->preprograms()->create([
                    'activity' => $request->activity[$i],
                    'start_date_time' => $request->start_date[$i],
                    'end_date_time' => $request->end_date[$i],
                ]);
        }

        $formType = 'Activity Proposal Form';
        $adviserEmail = $orgAdviser->fromUser->email;

        $currEmail = auth()->user()->email;
        $formTitle = $form->event_title;

        Mail::to($currEmail)->send(new apfSubmittedEmail());
        Mail::to($adviserEmail)->send(new FormApproverEmail($formType, $formTitle));

        return redirect('dashboard')->with('add-apf', 'Activity Proposal Form was successfully created!');
    }

    
    // update form
    public function update(APFRequest $request, Form $forms)
    {
        $proposal = $request->safe()->except(['target_date','org_id','event_title','coorganization', 'coorganizer_name', 'coorganizer_phone', 'coorganizer_email', 'service', 'logistics_date_needed','logistics_venue', 'activity', 'start_date', 'end_date', 'coorganizers', 'requests', 'programs' ]);

        $forms = $forms->update(array(
            'target_date' => $request->target_date,
            'event_title' => $request->event_title,
            'organization_id' => $request->org_id,
            'status' => 'Pending'
        )); 



        $proposal = $forms->proposal()->update($proposal);

        dd($proposal->logisticalNeed());

         // Logistics update
         for($i = 0; $i < count($request->service); $i++){
            $proposal->logisticalNeed()->update([
                    'service' => $request->service[$i],
                    'date_needed' => $request->logistics_date_needed[$i],
                    'venue' => $request->logistics_venue[$i],
                ]);
        }

         // External Coorg update
         for($i = 0; $i < count($request->coorganization); $i++){
            $proposal->externalCoorganizer()->update([
                    'coorganization' => $request->coorganization[$i],
                    'coorganizer' => $request->coorganizer_name[$i],
                    'email' => $request->coorganizer_phone[$i],
                    'phone_number' => $request->coorganizer_email[$i],
                ]);
        }

        // Pre-programs update
        for($i = 0; $i < count($request->activity); $i++){
            $proposal->preprograms()->update([
                    'activity' => $request->activity[$i],
                    'start_date_time' => $request->start_date[$i],
                    'end_date_time' => $request->end_date[$i],
                ]);
        }

        $formType = 'Activity Proposal Form';
        $adviserEmail = $orgAdviser->fromUser->email;

        $currEmail = auth()->user()->email;
        $formTitle = $forms->event_title;

        Mail::to($currEmail)->send(new apfSubmittedEmail());
        Mail::to($adviserEmail)->send(new FormApproverEmail($formType, $formTitle));

         
        return redirect()->route('dashboard')->with('add', 'Updated successfully!');
    }

    // delete form
    public function destroy($id)
    {
        //
    }

    // Control Number
    public function generateUniqueCode()
    {
        do {
            $control_number = random_int(100000, 999999);
        } while (Form::where("control_number", "=", $control_number)->first());
  
        return $control_number;
    }

    // Event Code/Id
    public function generateEventId()
    {
        do {
            $event_id = random_int(100000, 999999);
        } while (Form::where("event_id", "=", $event_id)->first());
  
        return $event_id;
    }


}
