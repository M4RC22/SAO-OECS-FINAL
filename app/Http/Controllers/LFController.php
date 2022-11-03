<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Form;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Mail\FormApproverEmail;
use App\Http\Requests\LFRequest;
use App\Models\OrganizationUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LFController extends Controller
{
    public function index()
    {
        // Fetch !! Approved !! events (via APF) that exists in orgs curr user belongs 
        $eventList = Form::where('form_type', '=', 'APF')
            ->where(function ($query) {
                $authOrgList = Auth::user()->studentOrg->pluck('id')->toArray();
                $query->whereIn('organization_id',$authOrgList);
                $query->where('status','Approved');
            })->orderBy('event_title')->get(['event_title', 'event_id']);

        return view('_student-organization.forms.liquidation', compact('eventList'))
        ->with("message", "Hello LF!"); 
    }

    public function store(LFRequest $request)
    {   
        dd($request);
        
        $lf = $request->safe()->only(['end_date','cash_advance','deduct']);
        $event = Form::where('event_id', $request->event_id)->get()->first();

         // get ID for approvers
         $orgAdviser = OrganizationUser::where('organization_id',$event->organization_id)
         ->where('position', 'Adviser')->pluck('id')->first();

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
            'organization_user_adviser_id' => $orgAdviser,
            'sao_staff_id' => $sao,
            'acadserv_staff_id' => $acadserv,
            'finance_staff_id' => $finance ,
            'event_id' => $request->event_id,
            'form_type' => 'LF',
            'target_date' => $event->target_date,
            'deadline' => Carbon::now()->setTimezone('Asia/Manila')->addDays(3),
        ]);

        // Liquidation Create
        $liquidation = $form->liquidation()->create($lf);

        // Proof of Payments create
        for($i = 0; $i < count($request->itemFrom); $i++){
            //store image in storage before inserting to databse.
            $imagePath = $request->image[$i]->store('uploads/receipts', 'public');
            
            $liquidation->proofOfPayment()->create([
                'item_from' => $request->itemFrom[$i],
                'item_to' => $request->itemTo[$i],
                'image' => $imagePath,
            ]);
        }

        // Liquidation Items create
        for($i = 0; $i < count($request->item_number); $i++){
            $liquidation->liquidationItem()->create([
                    'item_number' => $request->item_number[$i],
                    'date_bought' => $request->date_bought[$i],
                    'item' => $request->item[$i],
                    'price' => $request->price[$i],
                ]);
        }


        $formType = 'Liquidation Form';
        $adviserEmail = $orgAdviser->fromUser->email;

        $currEmail = auth()->user()->email;
        $formTitle = $form->event_title;

        Mail::to($currEmail)->send(new lfSubmittedEmail());
        Mail::to($adviserEmail)->send(new FormApproverEmail($formType, $formTitle));

        return redirect('dashboard')->with('add', 'Liquidation Form created successfully!');
       
    }

    public function update(LFRequest $request, Form $forms)
    {
        dd($request);
        
        $lf = $request->safe()->only(['end_date','cash_advance','deduct']);

        $forms->update(array(
            'event_id' => $request->event_id,
            'status' => 'Pending'
        )); 

        // Liquidation Create
        $liquidation = $forms->requisition()->update($lf);

       // Proof of Payments update
       for($i = 0; $i < count($request->itemFrom); $i++){
        //store image in storage before inserting to databse.
        $imagePath = $request->image[$i]->store('uploads/receipts', 'public');
        
        $liquidation->proofOfPayment()-update([
            'item_from' => $request->itemFrom[$i],
            'item_to' => $request->itemTo[$i],
            'image' => $imagePath,
            ]);
        }

        // Liquidation Items update
        for($i = 0; $i < count($request->item_number); $i++){
            $liquidation->liquidationItem()->update([
                    'item_number' => $request->item_number[$i],
                    'date_bought' => $request->date_bought[$i],
                    'item' => $request->item[$i],
                    'price' => $request->price[$i],
                ]);
        }

        $formType = 'Liquidation Form';
        $adviserEmail = $orgAdviser->fromUser->email;

        $currEmail = auth()->user()->email;
        $formTitle = $forms->event_title;

        Mail::to($currEmail)->send(new lfSubmittedEmail());
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
