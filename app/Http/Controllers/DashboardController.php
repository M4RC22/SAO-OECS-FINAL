<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use App\Models\Event;
use App\Models\Department;
use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Models\OrganizationUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){

        /********************************** 
        * 
        *  For different users
        * 
        **********************************/

        if(Auth::user()->checkUserType('Professor|Staff')){
            $user = auth()->user();
            $staff = $user->userStaff;
            $isHead = $staff->position === 'Head';
            $department = DB::table('departments')->find($staff->department_id);

            // APPROVER TYPE: Check if true or false
            $isAdviser = $user->checkPosition('Adviser');
            $isSaoHead = $department->name === 'Student Activities Office' && $isHead;
            $isAcadServHead = $department->name === 'Academic Services' && $isHead;
            $isFinanceHead = $department->name === 'Finance Office'  && $isHead;

            if($isAcadServHead || $isFinanceHead){
                $isAcadservOrFinance = true ;

            }else{
                $isAcadservOrFinance = false ;

            }


            // Getting the forms and destructuring it.
           $getForms = Form::where('status', '=', 'Pending')
            ->where(function ($query) {
                $user = auth()->user();
                $staff = $user->userStaff;
                $isHead = $staff->position === 'Head';
                $department = DB::table('departments')->find($staff->department_id);

                // APPROVER TYPE: Check if true or false
                $isAdviser = $user->checkPosition('Adviser');
                $isSaoHead = $department->name === 'Student Activities Office' && $isHead;
                $isAcadServHead = $department->name === 'Academic Services' && $isHead;
                $isFinanceHead = $department->name === 'Finance Office'  && $isHead;
                
                // LIST: id of curr user belongs to
                $getAuthOrgIdList = $user->studentOrg->pluck('id');

                // LIST: orgUserId of curr user
                $getAuthOrgUserIdList = $user->checkOrgUser->pluck('id'); 
                
                if($isAdviser === true && $isSaoHead === false && $isAcadServHead === false && $isFinanceHead === false){
                        $isAcadservOrFinance = false;
                
                    //    dd('test')    ;
                        $query->whereIn('adviser_staff_id', $getAuthOrgUserIdList );
                        $query->whereIn('organization_id', $getAuthOrgIdList);
                        $query->where('curr_approver', 'Adviser');                  
                        $query->where('adviser_is_approve', 0);     
                    
                }else{
              
                    if($isSaoHead){
                        $isAcadservOrFinance = false;
                        $query->where('sao_staff_id', $staff->id);
                        $query->where('curr_approver', 'SAO');
                        $query->where('adviser_is_approve', 1);
                        $query->where('sao_is_approve', 0); 
                        $query->orwhere(function ($query) {
                            $user = auth()->user();
                            $staff = $user->userStaff;
                            $isHead = $staff->position === 'Head';
                            $department = DB::table('departments')->find($staff->department_id);

                            // APPROVER TYPE: Check if true or false
                            $isAdviser = $user->checkPosition('Adviser');
                            $isSaoHead = $department->name === 'Student Activities Office' && $isHead;
                            $isAcadServHead = $department->name === 'Academic Services' && $isHead;
                            $isFinanceHead = $department->name === 'Finance Office'  && $isHead;
                            
                            // LIST: id of curr user belongs to
                            $getAuthOrgIdList = $user->studentOrg->pluck('id');

                            // LIST: orgUserId of curr user
                            $getAuthOrgUserIdList = $user->checkOrgUser->pluck('id');

                            if($isAdviser){
                                    $query->whereIn('adviser_staff_id', $getAuthOrgUserIdList );
                                    $query->whereIn('organization_id', $getAuthOrgIdList);
                                    $query->where('curr_approver', 'Adviser');                  
                                    $query->where('adviser_is_approve', 0);     
                                }   
                        });
                    }                                                
                    if($isAcadServHead){
                        $isAcadservOrFinance = true;
                        $query->where('acadserv_staff_id', $staff->id);
                        $query->where('curr_approver', 'Academic Services');
                        $query->where('sao_is_approve', 1);
                        $query->where('acadserv_is_approve', 0); 
                        $query->orwhere(function ($query) {
                            $user = auth()->user();
                            $staff = $user->userStaff;
                            $isHead = $staff->position === 'Head';
                            $department = DB::table('departments')->find($staff->department_id);

                            // APPROVER TYPE: Check if true or false
                            $isAdviser = $user->checkPosition('Adviser');
                            $isSaoHead = $department->name === 'Student Activities Office' && $isHead;
                            $isAcadServHead = $department->name === 'Academic Services' && $isHead;
                            $isFinanceHead = $department->name === 'Finance Office'  && $isHead;
                            
                            // LIST: id of curr user belongs to
                            $getAuthOrgIdList = $user->studentOrg->pluck('id');

                            // LIST: orgUserId of curr user
                            $getAuthOrgUserIdList = $user->checkOrgUser->pluck('id');

                            if($isAdviser){
                                    $query->whereIn('adviser_staff_id', $getAuthOrgUserIdList );
                                    $query->whereIn('organization_id', $getAuthOrgIdList);
                                    $query->where('curr_approver', 'Adviser');                  
                                    $query->where('adviser_is_approve', 0);     
                                }   
                        });   
                    }          
                    if($isFinanceHead){
                        $isAcadservOrFinance = true;
                        $query->where('finance_staff_id', $staff->id);
                        $query->where('curr_approver', 'Finance');
                        $query->where('acadserv_is_approve', 1);
                        $query->where('finance_is_approve', 0);   
                        $query->orwhere(function ($query) {
                            $user = auth()->user();
                            $staff = $user->userStaff;
                            $isHead = $staff->position === 'Head';
                            $department = DB::table('departments')->find($staff->department_id);

                            // APPROVER TYPE: Check if true or false
                            $isAdviser = $user->checkPosition('Adviser');
                            $isSaoHead = $department->name === 'Student Activities Office' && $isHead;
                            $isAcadServHead = $department->name === 'Academic Services' && $isHead;
                            $isFinanceHead = $department->name === 'Finance Office'  && $isHead;
                            
                            // LIST: id of curr user belongs to
                            $getAuthOrgIdList = $user->studentOrg->pluck('id');

                            // LIST: orgUserId of curr user
                            $getAuthOrgUserIdList = $user->checkOrgUser->pluck('id');

                            if($isAdviser){
                                    $query->whereIn('adviser_staff_id', $getAuthOrgUserIdList );
                                    $query->whereIn('organization_id', $getAuthOrgIdList);
                                    $query->where('curr_approver', 'Adviser');                  
                                    $query->where('adviser_is_approve', 0);     
                                }   
                        });        
                    }
                }
            })->get();
            // dd($getForms, $isAcadservOrFinance);
           $forms = [];
           foreach($getForms as $form){
                array_push($forms, [
                    'id' => Helper::encrypt($form->id),
                    'organization' => $form->myOrg->getOrgName->org_name,
                    'event_title' => $form->event_title,
                    'form_type' => $form->form_type,
                    'deadline' => $form->deadline,
                ]);
           }

            return view('_approvers.dashboard', compact('forms', 'isAcadservOrFinance'));

        }
        return view('_users.dashboard');
                
        }elseif(Auth::user()->checkUserType('Student')){

            /**************************************************
            *  Fetch form with event id na org id == myorglist
            ***************************************************/
            $authOrgList = Auth::user()->studentOrg->pluck('id')->toArray();
            // $myForms = Form::whereIn('organization_id', $authOrgList)->get();

            $myForms = Form::whereIn('organization_id', $authOrgList)
            ->where(function ($query) {
                $query->where('status','Pending')->orWhere('status', 'Denied');
            })->orderBy('created_at', 'desc')->get();


            return view('_student-organization.dashboard', compact('myForms'));
        }
    }
       

    public function cancel(Request $request)
    {
        $form = Form::findOrFail($request->formId);
        $eventTitle = $form->event_title;
        
        if($eventTitle === $request->checker){
            $form->status = "Cancelled";
            $form->update();

            $message = $request->checker. " was succesfully cancelled!";

            return redirect()->back()->with('remove', $message);
        }
        
        return redirect()->back()->with('error', 'Do not try it again! This action is recorded.');
    }

    // show form to edit
    public function show(Form $forms)
    {
        $authOrgList = Auth::user()->studentOrg;
        $message = $forms->remarks;

        if($forms->form_type === 'APF'){

            $proposal = $forms->proposal;
            $externalCoorganizers = $proposal->externalCoorganizer;
            $logisticalNeeds =  $proposal->logisticalNeed;
            $preprograms = $proposal->preprograms;
    
            return view('_student-organization.edit-forms.activity-proposal', compact('forms','message', 'authOrgList', 'proposal', 'externalCoorganizers', 'logisticalNeeds', 'preprograms' ));
    
        }elseif($forms->form_type === 'BRF'){

            $requisition = $forms->requisition;
            $reqItems = $requisition->reqItems;
            $eventList = Form::where('form_type', '=', 'APF')
            ->where(function ($query) {
                $authOrgList = Auth::user()->studentOrg->pluck('id')->toArray();
                $query->whereIn('organization_id',$authOrgList);
                $query->where('status','Pending');
            })->orderBy('event_title')->get(['event_title', 'event_id']);
            $departments = Department::orderBy('name')->get();

            return view('_student-organization.edit-forms.budget-requisition', compact('forms','message', 'authOrgList', 'eventList', 'departments', 'requisition', 'reqItems'));


        }elseif ($forms->form_type === 'NR') {

            $narrative = $forms->narrative;
            $narrativeImages = $narrative->narrativeImage;
            $participants = $narrative->participant;
            $postPrograms = $narrative->postProgram;
            $commentSuggestions = $narrative->commentSuggestion;
            $eventList = Form::where('form_type', '=', 'APF')
            ->where(function ($query) {
                $authOrgList = Auth::user()->studentOrg->pluck('id')->toArray();
                $query->whereIn('organization_id',$authOrgList);
                $query->where('status','Pending');
            })->orderBy('event_title')->get(['event_title', 'event_id']);
            $departments = Department::orderBy('name')->get();

            return view('_student-organization.edit-forms.narrative', compact('forms','message', 'authOrgList', 'eventList', 'departments', 'narrative', 'narrativeImages', 'participants', 'postPrograms', 'commentSuggestions' ));

        }elseif ($forms->form_type === 'LF') {

            $liquidation = $forms->liquidation;
            $proofOfPayments = $liquidation->proofOfPayment;
            $liquidationItems = $liquidation->liquidationItem;
            $eventList = Form::where('form_type', '=', 'APF')
            ->where(function ($query) {
                $authOrgList = Auth::user()->studentOrg->pluck('id')->toArray();
                $query->whereIn('organization_id',$authOrgList);
                $query->where('status','Pending');
            })->orderBy('event_title')->get(['event_title', 'event_id']);
            $departments = Department::orderBy('name')->get();

            return view('_student-organization.edit-forms.liquidation', compact('forms','message', 'authOrgList', 'eventList', 'departments',  'liquidation', 'proofOfPayments', 'liquidationItems' ));
        }
      
    }



}
