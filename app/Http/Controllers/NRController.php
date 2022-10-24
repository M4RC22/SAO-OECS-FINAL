<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Requests\NRRequest;
use App\Models\OrganizationUser;
use Illuminate\Support\Facades\Auth;

class NRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch !! Approved !! events (via APF) that exists in orgs curr user belongs 
        $eventList = Form::where('form_type', '=', 'APF')
            ->where(function ($query) {
                $authOrgList = Auth::user()->studentOrg->pluck('id')->toArray();
                $query->whereIn('organization_id',$authOrgList);
                $query->where('status','Approved');
            })->orderBy('event_title')->get(['event_title', 'event_id']);

        return view('_student-organization.forms.narrative', compact('eventList'));
    }

    public function store(NRRequest $request)
    {
        // dd($request);
        $nr = $request->safe()->only(['venue', 'remarks', 'ratings' ]);
        $event = Form::where('event_id', $request->event_id)->get()->first();

         // get ID for approvers
         $orgAdviser = OrganizationUser::where('organization_id',$event->organization_id)
         ->where('position', 'Adviser')->pluck('id')->first();

        $sao = Staff::whereHas('staffDepartment', function($q){
                $q->where('name', '=', 'Student Activities Office');
            })->where('position', 'Head')->pluck('id')->first();

        $acadserv = Staff::whereHas('staffDepartment', function($q){
                $q->where('name', '=', 'Academic Services');
            })->where('position', 'Head')->pluck('id')->first();

        $finance = Staff::whereHas('staffDepartment', function($q){
                $q->where('name', '=', 'Finance Office');
            })->where('position', 'Head')->pluck('id')->first();

     
        $form = Form::create([
            'event_title' => $event->event_title,
            'organization_id' => $event->organization_id,
            'prep_by' => auth()->id(),
            'control_number'=> $this->generateUniqueCode(),
            'adviser_staff_id' => $orgAdviser,
            'sao_staff_id' => $sao,
            'acadserv_staff_id' => $acadserv,
            'finance_staff_id' => $finance ,
            'event_id' => $request->event_id,
            'form_type' => 'NR',
            'target_date' => $event->target_date
        ]);

        // // Narrative Create
        $narrative = $form->narrative()->create($nr);

        // // Narrative Images create
        // for($i = 0; $i < count($request->poster); $i++){
        //     $imageName = 'narrative'.time().'.'.$request->narrative[$i]->extension();
        //     $narrative->narrativeImage()->create([
        //         'event_image' => $request->poster[$i]->storeAs('narrative',$imageName),
        //         'image_type' => 'poster'
        //     ]);
        // }

        // // Narrative Images create
        // for($i = 0; $i < count($request->event_image); $i++){
        //     $imageName = 'narrative'.time().'.'.$request->narrative[$i]->extension();
        //     $narrative->narrativeImage()->create([
        //         'event_image' => $request->event_image[$i]->storeAs('narrative',$imageName),
        //         'image_type' => 'event image'
        //     ]);
        // }

        // Participants create
        for($i = 0; $i < count($request->first_name); $i++){
            $narrative->participant()->create([
                    'first_name' => $request->first_name[$i],
                    'last_name' => $request->last_name[$i],
                    'section' => $request->section[$i],
                    'participated_date' => $request->participated_date[$i],
            ]);
        }

        // Post Programs create
        for($i = 0; $i < count($request->activity); $i++){
            $narrative->postProgram()->create([
                    'activity' => $request->activity[$i],
                    'start_date' => $request->start_date[$i],
                    'end_date' => $request->end_date[$i],
            ]);
        }

        // Comment Suggestions create
        for($i = 0; $i < count($request->comments); $i++){
            $narrative->commentSuggestion()->create([
                   'message' => $request->comments[$i],
                   'type' => 'comment'
                    
            ]);
        }

        // Comment Suggestions create
        for($i = 0; $i < count($request->suggestions); $i++){
            $narrative->commentSuggestion()->create([
                   'message' => $request->suggestions[$i],
                   'type' => 'suggestion'
            ]);
        }

        return redirect('dashboard')->with('add-nr', 'Narrative Report was successfully created!');

        

    }

   
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateUniqueCode()
    {
        do {
            $control_number = random_int(100000, 999999);
        } while (Form::where("control_number", "=", $control_number)->first());
  
        return $control_number;
    }
}
