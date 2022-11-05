<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helper\Helper;
use App\Models\OrganizationUser;
use PDF;

class RecordsController extends Controller
{
    public function index()
    {
        /******************************************************************
        *  Fetch forms: 
        *  1. must be pending
        *  2. must have forms.curr_approver = current user's dept/name + isHead 
        *  (defines the forms place in process)
        *  3. must have its staff_id == (approver)_staff_id // org = orgUser ID
        *   
        *       Forms ----> Staff and OrgUser, thats where we will check 
        *       the id on forms 
        *   
        ********************************************************************/
        if((Auth::user()->checkUserType('Professor') && Auth::user()->isOrgMember()) || 
            (Auth::user()->checkUserType('Student') && Auth::user()->isOrgMember()) ||
            Auth::user()->checkUserType('Staff')){

            $approvedAndCancelled = Form::where('status', '=', 'Approved')
                ->orWhere('status', '=', 'Cancelled')
                ->where(function ($query) {
                    $user = auth()->user();
                    // LIST: id of curr user belongs to
                    $getAuthOrgIdList = $user->studentOrg->pluck('id');

                    // LIST: orgUserId of curr user
                    $getAuthOrgUserIdList = $user->checkOrgUser->pluck('id');

                    if($user->checkUserType('Professor|Staff')){
                        $staff = $user->userStaff;
                        $isHead = $staff->position === 'Head';
                        $department = DB::table('departments')->find($staff->department_id);
        
                        // APPROVER TYPE: Check if true or false
                        $isAdviser = $user->checkPosition('Adviser');
                        $isSaoHead = $department->name === 'Student Activities Office' && $isHead;
                        $isAcadServHead = $department->name === 'Academic Services' && $isHead;
                        $isFinanceHead = $department->name === 'Finance Office'  && $isHead;
        
                        if($isAdviser === true && $isSaoHead === false && $isAcadServHead === false && $isFinanceHead === false){
                            $query->whereIn('organization_user_adviser_id', $getAuthOrgUserIdList );
                            $query->whereIn('organization_id', $getAuthOrgIdList);
                            $query->where('adviser_is_approve', 1);         
                            
                        }else{
                    
                            if($isSaoHead){
                                $query->where('sao_staff_id', $staff->id);
                                $query->where('sao_is_approve', 1);   
                                $query->where('form_type', '!=' , 'LF'); 
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
                                        $query->whereIn('organization_user_adviser_id', $getAuthOrgUserIdList );
                                        $query->whereIn('organization_id', $getAuthOrgIdList);
                                        $query->where('adviser_is_approve', 1);          
                                    }   
                                });
                            }                                                
                            if($isAcadServHead){
                                $query->where('acadserv_staff_id', $staff->id);
                                $query->where('sao_is_approve', 1);
                                $query->where('acadserv_is_approve', 1);
                                $query->where('form_type', '!=' , 'NR'); 
                                $query->where('form_type', '!=' , 'LF');   
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
                                        $query->whereIn('organization_user_adviser_id', $getAuthOrgUserIdList );
                                        $query->whereIn('organization_id', $getAuthOrgIdList);
                                        $query->where('adviser_is_approve', 1);            
                                    }   
                                });   
                            }          
                            if($isFinanceHead){
                                $query->where('finance_staff_id', $staff->id);
                                $query->where('acadserv_is_approve', 1);
                                $query->where('finance_is_approve', 1); 
                                $query->where('form_type', '!=' , 'NR');  
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
                                        $query->whereIn('organization_user_adviser_id', $getAuthOrgUserIdList );
                                        $query->whereIn('organization_id', $getAuthOrgIdList);
                                        $query->where('adviser_is_approve', 1);        
                                    }   
                                });        
                            }
                        }


                

                    }elseif($user->checkUserType('Student')){

                        $getAuthOrgIdList = $user->studentOrg->pluck('id');
                        $query->whereIn('organization_id', $getAuthOrgIdList); 

                    }
                    
                })->paginate(10)->sortByDesc('updated_at');

            
                    $records = [];
            
                    foreach($approvedAndCancelled as $form){
                        array_push($records, [
                            'id' => $form->id,
                            'formType' => $form->form_type,
                            'eventTitle' => $form->event_title,
                            'status' => $form->status,
                            'date' => Carbon::parse($form->updated_at)->format('F d, Y - h:i A'),
                            'organization' => $form->myOrg->getOrgName->org_name,
                        ]);
                    }

                return view('_users.records', compact('records'));
        }
        abort(403);
    }

    public function download($id)
    {
        $form =  Form::findOrFail($id);
        
        //Activity Proposal Form
        if($form->form_type === 'APF'){
           $proposal = $form->proposal()->first();
           $coorganizers = $proposal->externalCoorganizer()->get();
           $requests = $proposal->logisticalNeed()->get();
           $prePrograms = $proposal->preprograms()->get();
           
           $pdf = PDF::loadview('_users.pdf.activity-proposal', compact('form', 'proposal', 'coorganizers', 'requests', 'prePrograms'));
           
           $fileName = $form->form_type." - ".$form->event_title.".pdf";

           return $pdf->download($fileName);

        }

        //Budget Requisition Form
        if($form->form_type === 'BRF'){
            $requisition = $form->requisition()->first();
            $items = $requisition->reqItems()->get();

            $pdf = PDF::loadview('_users.pdf.budget-requisition', compact('form', 'requisition', 'items'));
           
            $fileName = $form->form_type." - ".$form->event_title.".pdf";
 
            return $pdf->download($fileName);

        }

        //Narrative Report
        if($form->form_type === 'NR'){
            $narrative = $form->narrative()->first();
            $participants = $narrative->participant()->get();
            $commentSuggestions = $narrative->commentSuggestion()->get();
            $postPrograms = $narrative->postProgram()->get();
            $images = $narrative->narrativeImage()->get();

            $pdf = PDF::loadview('_users.pdf.narrative', compact('form', 'narrative', 'participants', 'commentSuggestions', 'postPrograms', 'images'));
           
            $fileName = $form->form_type." - ".$form->event_title.".pdf";
 
            return $pdf->download($fileName);

        }

        //Liquidation Form
        if($form->form_type === 'LF'){
            $liquidation = $form->liquidation()->first();
            $items = $liquidation->liquidationItem()->get();
            $proofOfPayments = $liquidation->proofOfPayment()->get();

            $pdf = PDF::loadview('_users.pdf.liquidation', compact('form', 'liquidation', 'items', 'proofOfPayments'));
           
            $fileName = $form->form_type." - ".$form->event_title.".pdf";
 
            return $pdf->download($fileName);
        }

    }
}
