<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helper\Helper;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\NewDeptHeadEmail;
use App\Mail\RemoveDeptHeadEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class DepartmentHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $heads = DB::table('staff')->where('position', '=', 'Head')->get();

        $departmentHeads = [];

        foreach($heads as $head){
            $department = DB::table('departments')->where('id', '=', $head->department_id)->first()->name;
            $appproverName = DB::table('users')->where('id', '=', $head->user_id)->first();
            array_push($departmentHeads, [
                'user_id' => $head->user_id,
                'department_id' => $head-> department_id,
                'name' => $appproverName->first_name." ".$appproverName->last_name,
                'department' => $department,
                'position' => $head->position,
            ]);
        }

        return view('_approvers.department-head-list', compact('departmentHeads'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($departmentId, $userId)
    {
        $headInfo = User::findOrFail($userId);
        $departmentInfo = Department::findOrFail($departmentId);

        return view('_approvers.department-head-assign', compact('headInfo', 'departmentInfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $departmentId, $userId)
    {
        //Check if user alredy have data on the 'users' table
        if(User::where('email', $request->email)->doesntExist()){
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
                ]
            );

            //create/store fetched
            $getUser = $response[$key+1];

            //Check if user is staff or professor
            if($getUser->userType != "Staff" && $getUser->userType != "Professor"){
                return Redirect::route('department-heads.index')->with('error', "Sorry, the action is cannot be done!");
            }
            
            $user = User::create([
                'first_name' => $getUser->firstName,
                'middle_name' => $getUser->middleName,
                'last_name' => $getUser->lastName,
                'phone_number' => $getUser->phoneNumber,
                'email' => $getUser->email,
                'user_type' => $getUser->userType,
                'password' => bcrypt($getUser->password)
                ]);

        }else{
            $recruiteeId = User::where('email', $request->email)->first()->id;
            $user = User::findOrFail($recruiteeId);

        }

        //Checks if assignee is already a department head.
        if($user->userStaff()->exists()){
            if($user->userStaff()->first()->position){
                return Redirect::route('department-heads.index')->with('error', "Sorry, the action is cannot be done!");
            }
        }
        
        //dettach current department head from department.
        $currentHead = User::findOrFail($userId);
        $currHeadEmail = $currentHead->email;
        $newHeadEmail = $user->email;
        $dept = Department::where('id', $departmentId)->pluck('name')->first();
        // dd($currHeadEmail, $newHeadEmail, $dept);
        $currentHead->userStaff()->delete($departmentId); 

        //attach new department head
        $user->userStaff()->create([
            'user_id' => $user->id,
            'department_id' => $departmentId,
            'position' => 'Head',
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now'))

        ]);

        Mail::to($currHeadEmail)->send(new RemoveDeptHeadEmail($dept));
        Mail::to($newHeadEmail)->send(new NewDeptHeadEmail($dept));



        return Redirect::route('department-heads.index')->with('add', 'New Department Head was assigned!');
        dd('tes');
    }

}
