<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helper\Helper;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\OrganizationUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\AddOrganizationMemberEmail;
use Illuminate\Support\Facades\Redirect;
use App\Mail\EditOrganizationMemberEmail;
use App\Mail\RemoveOrganizationMemberEmail;

class OrganizationController extends Controller
{
    public function index()
    {
        $getAuthOrgList = Auth::user()->studentOrg;

        //Pagination
        $authOrgList = Helper::paginate($getAuthOrgList, count($getAuthOrgList), 10); 

        return view('_users.organization-list', compact('authOrgList'));
    }



    public function show($orgId)
    {
        Helper::isAuthorized('Moderator|Viewer|Editor', $orgId);
        $currOrg = Organization::with('studentOrg')->where('id', '=', $orgId)->first();
        $getOrgMembers = $currOrg->studentOrg;
        $totalMembers = count($getOrgMembers);
    
        $orgMembers = Helper::paginate($getOrgMembers, count($getOrgMembers), 10);
        
        return view('_users.organization-info', compact('currOrg', 'orgMembers', 'totalMembers'));
    }



    public function add($orgId)
    {
        Helper::isAuthorized('Moderator', $orgId);
        $currOrg = Organization::with('studentOrg')->where('id', '=', $orgId)->first();

        return view('_users.organization-add', compact('currOrg'));
    }



    public function store(Request $request, $orgId)
    {  
        //fetch from dummy user api
        //Get key. if user is not in api = error
        $response = json_decode(Http::get('https://sao-oecs-users.herokuapp.com/users'));
        $key = array_search($request->email, array_column($response, 'email'));

        // // valitdate request
        $request->validate([ 
            'email' =>  [
                'required',
                'email',
                // Rule::unique('user','email'),
                function($attribute, $value, $fail){
                    $response = json_decode(Http::get('https://sao-oecs-users.herokuapp.com/users'));
                    $key = array_search($value, array_column($response, 'email'));
                    $inUsers = User::where('email', $value)->exists();

                    if($inUsers === false){
                        if($key === false){
                            $fail("User not found. Please use valid APC Email!");
                        }
                    }
                   
                }],
            'position' => 'required|regex:/^[\pL\s]+$/u|max:30',
            'role' => 'required'  
            ], 
            [
            'role.required' => 'Role field is required'
            ]
        );

        //If user committed profanity
        if(Helper::checkWords($request->position)){
            return redirect()->back()->with('error', 'Prohibited Word. Do not try it again! This action is recorded.');
        }

        //create/store fetched
        $getUser = $response[$key+1];

        //Check if user alredy have data on the 'users' table
        if(!User::where('email', $request->email)->exists()){
            $user = User::create([
                'first_name' => $getUser->firstName,
                'middle_name' => $getUser->middleName,
                'last_name' => $getUser->lastName,
                'phone_number' => $getUser->phoneNumber,
                'email' => $getUser->email,
                'user_type' => $getUser->userType,
                'password' => bcrypt($getUser->password)
            ]);

        }

        $recruitee = User::where('email', $request->email)->first();
        $isUserAlredyInOrg = DB::table('organization_user')->where('organization_id', $orgId)->where('user_id', $recruitee->id)->exists(); 
        
        //Check if user is already part of the organization
        if($isUserAlredyInOrg){
            $message = 'User is already part of this organization!';
            return redirect()->back()->with('error', $message);
        }else{
            $position = ucfirst($request->position);
            $user = OrganizationUser::create([
                'user_id' => $recruitee->id,
                'organization_id' => $orgId,
                'position' => $position,
                'role' => $request->role,
            ]);

            // Email vals
            $orgName = $user->getOrgName->org_name;
            $role = $user->role;
            // dd($orgName,  $position, $role);
            $message = $recruitee->first_name.' '. $recruitee->last_name.' was successfully assigned as '. $position.'!';
            Mail::to($recruitee->email)->send(new AddOrganizationMemberEmail($orgName,  $position, $role));

        }
    
    

        //Register the fetched. This will send verification email. Customize the email under resources/views/vendor
        // event(new Registered($user));
    
        return Redirect::route('organization.show', ['id'=>$orgId])->with('add', $message);
    }



    public function select($orgId, $memberId)
    {
        Helper::isAuthorized('Moderator', $orgId);
        $currOrg = Organization::with('studentOrg')->where('id', '=', $orgId)->first();
        $selected = User::findorfail($memberId);

        return view('_users.organization-edit', compact('currOrg','selected'));
    }



    public function update(Request $request, $orgId, $memberId)
    {
        $selected = User::findorfail($memberId);
        
        $request->validate([
            'position' => 'required|regex:/^[\pL\s]+$/u|max:30',
            'role' => 'required' 
        ]);

        //If user commit profanity
        if(Helper::checkWords($request->position)){
            return redirect()->back()->with('error', 'Prohibited Word. Do not try it again! This action is recorded.');
        }

        //If user is adviser, then edit will not continue
        if($selected->studentOrg()->first()->pivot->position === "Adviser"){
            return redirect()->back()->with('error', 'Organization Adviser is not editable.');
        }

        //Checks if new adviser is professor or staff, if not return with error
        if($request->position === "Adviser" && $selected->user_type === "Student"){
            return redirect()->back()->with('error', 'Organization Adviser must be Staff or Professor.');
        }

        //capitalized first letter of position
        $position = ucfirst($request->position);
        $attributes = ['position' => $position, 'role' => $request->role];
        $selected->studentOrg()->updateExistingPivot($orgId, $attributes);
        $message = $selected->first_name.' '.$selected->last_name.' was succesfully edited!';

        // Mail data
        $orgName = $selected->studentOrg->first()->org_name;
        $role = $request->role;
        //  dd($orgName,  $position, $role);

        Mail::to($selected->email)->send(new EditOrganizationMemberEmail($orgName,  $position, $role));

        return Redirect::route('organization.show', ['id'=>$orgId])->with('edit', $message);
        
        
   
    }


    public function destroy($orgId, $member)
    {
        $selected = User::findorfail($member);
        $selected->studentOrg()->detach($orgId);
        $message = $selected->first_name.' '.$selected->last_name.' was successfully removed from the organization.';

        $orgName = Organization::where('id', $orgId)->pluck('org_name')->first();

        Mail::to($selected->email)->send(new RemoveOrganizationMemberEmail($orgName));

        return Redirect::route('organization.show', ['id'=>$orgId])->with('remove', $message);
    }
}
