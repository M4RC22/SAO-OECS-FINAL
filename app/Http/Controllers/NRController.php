<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Form;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Mail\nrSubmittedEmail;
use App\Mail\FormApproverEmail;
use App\Http\Requests\NRRequest;
use App\Models\OrganizationUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $nr = $request->safe()->only(['venue', 'narration', 'ratings' ]);
        $event = Form::where('event_id', $request->event_id)->get()->first();

         // get ID for approvers
         $orgAdviser = OrganizationUser::where('organization_id',$event->organization_id)
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

     
        $form = Form::create([
            'event_title' => $event->event_title,
            'organization_id' => $event->organization_id,
            'prep_by' => auth()->id(),
            'control_number'=> $this->generateUniqueCode(),
            'organization_user_adviser_id' => $orgAdviser->id,
            'sao_staff_id' => $sao,
            'acadserv_staff_id' => $acadserv,
            'finance_staff_id' => $finance ,
            'event_id' => $request->event_id,
            'form_type' => 'NR',
            'target_date' => $event->target_date,
            'deadline' => Carbon::now()->setTimezone('Asia/Manila')->addDays(3),
        ]);

        // // Narrative Create
        $narrative = $form->narrative()->create($nr);


        // Narrative Poster create
        $imagePath = $request->file('official_poster')->store('uploads/posters', 'public');
        $narrative->narrativeImage()->create([
            'url' => $imagePath,
            'image_type' => 'poster'
        ]);
        // Narrative Event Images create
        for($i = 0; $i < count($request->file('event_images')); $i++){
            $imagePath = $request->file('event_images')[$i]->store('uploads/photos', 'public');
            $narrative->narrativeImage()->create([
                'url' => $imagePath,
                'image_type' => 'photo'
            ]);
        }

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
        
        $formType = 'Narrative Report';
        $adviserEmail = $orgAdviser->fromUser->email;

        $currEmail = auth()->user()->email;
        $formTitle = $form->event_title;

        Mail::to($currEmail)->send(new nrSubmittedEmail());
        Mail::to($adviserEmail)->send(new FormApproverEmail($formType, $formTitle));

        return redirect('dashboard')->with('add-nr', 'Updated successfully! Submitted to approver.');

        

    }

    public function update(NRRequest $request, Form $forms)
    {

        $nr = $request->safe()->only(['venue', 'remarks', 'ratings' ]);

        $forms->update(array(
            'status' => 'Pending',
            'remarks' => '',
            'event_id' => $request->event_id,
            'status' => 'Pending'
        )); 

        // Narrative Update
        $forms->narrative()->update($nr);

        $narrative = $forms->narrative()->first();

        $narrative->narrativeImage()->delete();
        $narrative->participant()->delete();
        $narrative->postProgram()->delete();
        $narrative->commentSuggestion()->update();

           // Narrative Poster UPDATE
           $imagePath = $request->file('official_poster')->store('uploads/posters', 'public');
           $narrative->narrativeImage()->create([
               'url' => $imagePath,
               'image_type' => 'poster'
           ]);
           // Narrative Event Images UPDATE
           for($i = 0; $i < count($request->file('event_images')); $i++){
               $imagePath = $request->file('event_images')[$i]->store('uploads/photos', 'public');
               $narrative->narrativeImage()->create([
                   'url' => $imagePath,
                   'image_type' => 'photo'
               ]);
           }
   
           // Participants UPDATE
           for($i = 0; $i < count($request->first_name); $i++){
               $narrative->participant()->create([
                       'first_name' => $request->first_name[$i],
                       'last_name' => $request->last_name[$i],
                       'section' => $request->section[$i],
                       'participated_date' => $request->participated_date[$i],
               ]);
           }
   
           // Post Programs UPDATE
           for($i = 0; $i < count($request->activity); $i++){
               $narrative->postProgram()->create([
                       'activity' => $request->activity[$i],
                       'start_date' => $request->start_date[$i],
                       'end_date' => $request->end_date[$i],
               ]);
           }
   
           // Comment Suggestions UPDATE
           for($i = 0; $i < count($request->comments); $i++){
               $narrative->commentSuggestion()->create([
                      'message' => $request->comments[$i],
                      'type' => 'comment'
               ]);
           }
   
           // Comment Suggestions UPDATE
           for($i = 0; $i < count($request->suggestions); $i++){
               $narrative->commentSuggestion()->create([
                      'message' => $request->suggestions[$i],
                      'type' => 'suggestion'
               ]);
           }

        
           
        $formType = 'Narrative Report';
        $adviserEmail = $forms->getFormAdviser->fromUser->email;
        $currEmail = auth()->user()->email;
        $formTitle = $forms->event_title;

        Mail::to($currEmail)->send(new nrSubmittedEmail());
        Mail::to($adviserEmail)->send(new FormApproverEmail($formType, $formTitle));
        
        return back()->with('add', 'Updated successfully!');
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
