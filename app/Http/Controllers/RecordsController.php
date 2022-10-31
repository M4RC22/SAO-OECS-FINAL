<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helper\Helper;

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
        $user = auth()->user();
       
        if($user->checkUserType('Professor|Staff')){
            if(Helper::userExistsInStaff()){
                $approvedAndCancelled = Form::where('status', '=', 'Approved')
                    ->orWhere('status', '=', 'Cancelled')
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

                        if($isAdviser){
                            $query->whereIn('adviser_staff_id', $getAuthOrgUserIdList );
                            $query->whereIn('organization_id', $getAuthOrgIdList);
                            $query->where('adviser_is_approve', 1);            
                        }                
                        })->orWhere(function ($query) {
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
                
                                // LIST: id of curr user belongs to
                                $getAuthOrgIdList = $user->studentOrg->pluck('id');
                
                                // LIST: orgUserId of curr user
                                $getAuthOrgUserIdList = $user->checkOrgUser->pluck('id');

                            if($isSaoHead){
                                $query->where('sao_staff_id', $staff->id);
                                $query->where('sao_is_approve', 1);           
                        
                            }
                        })->orWhere(function ($query) {
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
                
                                // LIST: id of curr user belongs to
                                $getAuthOrgIdList = $user->studentOrg->pluck('id');
                
                                // LIST: orgUserId of curr user
                                $getAuthOrgUserIdList = $user->checkOrgUser->pluck('id');
                                
                            if($isAcadServHead){
                                $query->where('acadserv_staff_id', $staff->id);
                                $query->where('sao_is_approve', 1);
                                $query->where('acadserv_is_approve', 1);        
                            }
                        })->orWhere(function ($query) {
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
                
                                // LIST: id of curr user belongs to
                                $getAuthOrgIdList = $user->studentOrg->pluck('id');
                
                                // LIST: orgUserId of curr user
                                $getAuthOrgUserIdList = $user->checkOrgUser->pluck('id');

                            if($isFinanceHead){
                                $query->where('finance_staff_id', $staff->id);
                                $query->where('acadserv_is_approve', 1);
                                $query->where('finance_is_approve', 1);                    

                            }
                        })->paginate();

                        $records = [];
                
                        foreach($approvedAndCancelled as $form){
                            array_push($records, [
                                'id' => Helper::encrypt($form->id),
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

            }elseif($user->checkUserType('Student')){
               
                $approvedAndCancelled = Form::where('status', '=', 'Approved')
                ->orWhere('status', '=', 'Cancelled')
                ->where(function ($query) {
                    $user = auth()->user();

                    $getAuthOrgIdList = $user->studentOrg->pluck('id');
                    $query->whereIn('organization_id', $getAuthOrgIdList); 
                })->paginate(10);
                

                $records = [];
           
                foreach($approvedAndCancelled as $form){
                    array_push($records, [
                        'id' => Helper::encrypt($form->id),
                        'formType' => $form->form_type,
                        'eventTitle' => $form->event_title,
                        'status' => $form->status,
                        'date' => Carbon::parse($form->updated_at)->format('F d, Y - h:i A'),
                        'organization' => $form->myOrg->getOrgName->org_name,
                    ]);
                }

            return view('_users.records', compact('records'));
        }
    }
}