<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Staff;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use App\Models\OrganizationUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* 
            |========================================
            |
            | Users 5 - 9 : Brewing Minds Officers
            |
            | Users 10 : Adviser
            |
            | Users 11 - 19 : Dummy Stundents
            |
            |========================================        
        */

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/
        $this->command->info('Generating USERS data...');
 
        $users = [
            //1 - Sao Head
            [
                'first_name' => 'Sample',
                'middle_name' => null,
                'last_name' => 'Sao',
                'phone_number' => '09123456789',
                'user_type' => 'Staff',
                'email' => 'sao@apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //2 - Finance Head
            [
                'first_name' => 'Sample',
                'middle_name' => null,
                'last_name' => 'Finance',
                'phone_number' => '09123456789',
                'user_type' => 'Staff',
                'email' => 'finance@apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //3 - AcadServ
            [
                'first_name' => 'Sample',
                'middle_name' => null,
                'last_name' => 'AcadServ',
                'phone_number' => '09123456789',
                'user_type' => 'Staff',
                'email' => 'acadserv@apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //4 - Adviser
            [
                'first_name' => 'Sample',
                'middle_name' => null,
                'last_name' => 'Adviser',
                'phone_number' => '09123456789',
                'user_type' => 'Professor',
                'email' => 'adviser@apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //5 - Brewing Minds President
            [
                'first_name' => 'Michelle',
                'middle_name' => 'Montales',
                'last_name' => 'Manadero',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'mmmanadero@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //6 Brewing Minds Vice-President
            [
                'first_name' => 'Paul John',
                'middle_name' => 'Deluna',
                'last_name' => 'Signo',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'pdsigno@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //7 Brewing Minds - Secretary
            [
                'first_name' => 'Marc Kenneth',
                'middle_name' => 'Elfa',
                'last_name' => 'Ricahuerta',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'mericahuerta@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //8 Brewing Minds - Treasurer
            [
                'first_name' => 'Louise Gerard',
                'middle_name' => 'Martinez',
                'last_name' => 'Binotapa',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'lmbinotapa@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //9 Brewing Minds - Auditor
            [
                'first_name' => 'Therese Nicole',
                'middle_name' => 'Conception',
                'last_name' => 'Yumul',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'tcyumul@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //10 Adviser
            [
                'first_name' => 'Morganica',
                'middle_name' => 'Scanlan',
                'last_name' => 'Bounde',
                'phone_number' => '09123456789',
                'user_type' => 'Professor',
                'email' => 'msbounde@apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //11
            [
                'first_name' => 'Ellswerth',
                'middle_name' => 'Kinkaid',
                'last_name' => 'Pieche',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'ekpieche@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //12
            [
                'first_name' => 'Janice',
                'middle_name' => 'Stables',
                'last_name' => 'Baden',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'jsbaden@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //13
            [
                'first_name' => 'Mark',
                'middle_name' => 'Ludmann',
                'last_name' => 'Kittman',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'mlkittman@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //14
            [
                'first_name' => 'Cairistiona',
                'middle_name' => 'Kayser',
                'last_name' => 'Fellgatt',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'ckfellgatt@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //15
            [
                'first_name' => 'Sydney',
                'middle_name' => 'Yegorovnin',
                'last_name' => 'Vynall',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'syvynall@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //16
            [
                'first_name' => 'Gregorio',
                'middle_name' => 'Geake',
                'last_name' => 'Branthwaite',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'ggbranthwaite@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //17
            [
                'first_name' => 'Dyann',
                'middle_name' => 'Durgan',
                'last_name' => 'Enser',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'ddenser@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //18
            [
                'first_name' => 'Gale',
                'middle_name' => 'Appleby',
                'last_name' => 'Cheyenne',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'gacheyenne@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //19
            [
                'first_name' => 'Gale',
                'middle_name' => 'Origan',
                'last_name' => 'Marrion',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'gomarrion@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //20
            [
                'first_name' => 'Maxy',
                'middle_name' => 'Fairhall',
                'last_name' => 'Boobyer',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'mfboobyer@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //21
            [
                'first_name' => 'Obediah',
                'middle_name' => 'Gottelier',
                'last_name' => 'Faircliff',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'ogfaircliff@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //22
            [
                'first_name' => 'Harriott',
                'middle_name' => 'Dehn',
                'last_name' => 'Nyland',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'hdnyland@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //23
            [
                'first_name' => 'Jobye',
                'middle_name' => 'Cruces',
                'last_name' => 'Gibby',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'jcgibby@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //24
            [
                'first_name' => 'Coleman',
                'middle_name' => 'Scase',
                'last_name' => 'Jessop',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'csjessop@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            //25
            [
                'first_name' => 'Wally',
                'middle_name' => 'Lowry',
                'last_name' => 'Cragoe',
                'phone_number' => '09123456789',
                'user_type' => 'Student',
                'email' => 'wlcragoe@student.apc.edu.ph',
                'password' => bcrypt('R@M$xBM_2022')
            ],
            [
            //26 - Codeseekers Adviser
                'first_name' => 'Code',
                'middle_name' => 'xtianpogi',
                'last_name' => 'Seekers',
                'phone_number' => '09456643543',
                'user_type' => 'Professor',
                'email' => 'codeseekers@apc.edu.ph',
                'password' => bcrypt('xT1@n_p06!')
            ],
            //27 - Codeseekers President
            [
                'first_name' => 'Christian Paul',
                'middle_name' => null,
                'last_name' => 'Pili',
                'phone_number' => '09363378264',
                'user_type' => 'Student',
                'email' => 'cbpili@student.apc.edu.ph',
                'password' => bcrypt('xT1@n_p06!')
            ],

        ];

       
        foreach($users as $i){
            // User::create($i);
            User::create($i);
           
        }
        // User ID getter = $user1, $user2...
        $userEmail = array(
            'sao@apc.edu.ph',
            'finance@apc.edu.ph',
            'acadserv@apc.edu.ph',
            'adviser@apc.edu.ph',
            'mmmanadero@student.apc.edu.ph',
            'pdsigno@student.apc.edu.ph',
            'mericahuerta@student.apc.edu.ph',
            'lmbinotapa@student.apc.edu.ph',
            'tcyumul@student.apc.edu.ph',
            'msbounde@apc.edu.ph',
            'ekpieche@student.apc.edu.ph',
            'jsbaden@student.apc.edu.ph',
            'mlkittman@student.apc.edu.ph',
            'ckfellgatt@student.apc.edu.ph',
            'syvynall@student.apc.edu.ph',
            'ggbranthwaite@student.apc.edu.ph',
            'ddenser@student.apc.edu.ph',
            'gacheyenne@student.apc.edu.ph',
            'gomarrion@student.apc.edu.ph',
            'mfboobyer@student.apc.edu.ph',
            'ogfaircliff@student.apc.edu.ph',
            'hdnyland@student.apc.edu.ph',
            'jcgibby@student.apc.edu.ph',
            'csjessop@student.apc.edu.ph',
            'wlcragoe@student.apc.edu.ph',
            'codeseekers@apc.edu.ph',
            'cbpili@student.apc.edu.ph',
        );
        for($i=0;$i<count($userEmail);$i++){
           ${'user'.$i+1} = User::where('email', $userEmail[$i])->pluck('id')->first();
        }

        $this->command->info('USERS generated.');


/*
|--------------------------------------------------------------------------
| DEPARTMENT
|--------------------------------------------------------------------------
*/  

        $this->command->info('Generating DEPARTMENTS data...');

        $departments = [
            //1
            [
                'name' => 'Student Activities Office',
            ], 
            //2
            [
                'name' => 'Finance Office',
            ],
            //3
            [
                'name' => 'Academic Services',
            ],
            //4
            [
                'name' => 'School of Computing and Information Technology',
            ],
            //5
            [
                'name' => 'School of Multimedia and Arts',
            ],
            //6
            [
                'name' => 'School of Management',
            ],
            //7
            [
                'name' => 'School of Engineering',
            ],
        ];

        foreach($departments as $i){
            Department::create($i);
        }

        // Department ID getter = $dept1, $dept2...
        $deptName = array(
            'Student Activities Office',
            'Finance Office',
            'Academic Services',
            'School of Computing and Information Technology',
            'School of Multimedia and Arts',
            'School of Management',
            'School of Engineering',

        );
        for($i=0;$i<count($deptName);$i++){
           ${'dept'.$i+1} = Department::where('name', $deptName[$i])->pluck('id')->first();
        }

        $this->command->info('DEPARTMENTS generated.');


/*
|--------------------------------------------------------------------------
| ORGANIZATION
|--------------------------------------------------------------------------
*/
        $this->command->info('Generating ORGANIZATIONS data...');

        $organizations = [
            [
                'org_name' => 'Brewing Minds',
                'adviser' => 'Sample Adviser'
            ],
            [
                'org_name' => 'Gaming Genesis',
                'adviser' => 'Sample Sao'
            ],
            [
                'org_name' => 'APC Robotics Organization',
                'adviser' => 'Morganica Bounde'
            ],
            [
                'org_name' => 'Codeseekers',
                'adviser' => 'Code Seekers'
            ],        
            
        ];

        foreach($organizations as $i){
            Organization::create($i);
        }

        // Organization ID getter = $org1, $org2...
        $orgName = array(
            'Brewing Minds',
            'Gaming Genesis',
            'APC Robotics Organization',
            'Codeseekers',
        );
        for($i=0;$i<count($orgName);$i++){
           ${'org'.$i+1} = Organization::where('org_name', $orgName[$i])->pluck('id')->first();
        }

        $this->command->info('DEPARTMENTS generated.');


/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/
        $this->command->info('Generating STAFF data...');

        $staffs = [
            //SAO
            [
                'user_id' => $user1,
                'department_id' => $dept1,
                'position'=>'Head'
                
            ], 
            //Finance
            [
                'user_id' => $user2,
                'department_id' => $dept2,
                'position'=> 'Head'
                
            ], 
            //AcadServ
            [
                'user_id' => $user3,
                'department_id' => $dept3,
                'position'=> 'Head'
                
            ], 
            //Adviser - Sample Adviser
            [
                'user_id' => $user4,
                'department_id' => $dept4,
                'position'=> 'Professor'
                
            ], 
            //Adviser
            [
                'user_id' => $user10,
                'department_id' => $dept5,
                'position'=> 'Professor'
                
            ], 
            //Adviser - Codeseekers
            [
                'user_id' => $user26,
                'department_id' => $dept6,
                'position'=> 'Professor'
                
            ], 
        ];

        foreach($staffs as $i){
            Staff::create($i);
        }
        $this->command->info('STAFF generated.');

/*
|--------------------------------------------------------------------------
| ORGANIZATION_USER
|--------------------------------------------------------------------------
*/
        $this->command->info('Generating ORGANIZATION_USER data...');

        $orgusers = [
            //Brewing Minds
            [
                'user_id' => $user4,
                'organization_id' => $org1,
                'position'=>'Adviser',
                'role' => 'Moderator',
            ],
            [
                'user_id' => $user5,
                'organization_id' => $org1,
                'position'=>'President',
                'role' => 'Moderator',
            ],
            [
                'user_id' => $user6,
                'organization_id' => $org1,
                'position'=>'Vice-President',
                'role' => 'Moderator',
            ],
            [
                'user_id' => $user7,
                'organization_id' => $org1,
                'position'=>'Secretary',
                'role' => 'Editor',
            ],
            [
                'user_id' => $user8,
                'organization_id' => $org1,
                'position'=>'Treasurer',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user9,
                'organization_id' => $org1,
                'position'=>'Auditor',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user11,
                'organization_id' => $org1,
                'position'=>'Member',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user12,
                'organization_id' => $org1,
                'position'=>'Member',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user13,
                'organization_id' => $org1,
                'position'=>'Member',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user14,
                'organization_id' => $org1,
                'position'=>'Member',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user15,
                'organization_id' => $org1,
                'position'=>'Member',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user16,
                'organization_id' => $org1,
                'position'=>'Member',
                'role' => 'Viewer',
            ],

            // Gaming Genesis
            [
                'user_id' => $user1,
                'organization_id' => $org2,
                'position'=>'Adviser',
                'role' => 'Moderator',
            ],
            [
                'user_id' => $user11,
                'organization_id' => $org2,
                'position'=>'President',
                'role' => 'Moderator',
            ],
            [
                'user_id' => $user17,
                'organization_id' => $org2,
                'position'=>'Secretary',
                'role' => 'Editor',
            ],
            [
                'user_id' => $user18,
                'organization_id' => $org2,
                'position'=>'Member',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user19,
                'organization_id' => $org2,
                'position'=>'Member',
                'role' => 'Viewer',
            ],

            //APC Dance Company
            [
                'user_id' => $user10,
                'organization_id' => $org3,
                'position'=>'Adviser',
                'role' => 'Moderator',
            ],
            [
                'user_id' => $user20,
                'organization_id' => $org3,
                'position'=>'President',
                'role' => 'Moderator',
            ],
            [
                'user_id' => $user21,
                'organization_id' => $org3,
                'position'=>'Member',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user22,
                'organization_id' => $org3,
                'position'=>'Member',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user23,
                'organization_id' => $org3,
                'position'=>'Member',
                'role' => 'Viewer',
            ],
            [
                'user_id' => $user11,
                'organization_id' => $org3,
                'position'=>'Member',
                'role' => 'Viewer',
            ],

            // CodeSeekers
            [
                'user_id' => $user26,
                'organization_id' => $org4,
                'position'=>'Adviser',
                'role' => 'Moderator',
            ],
            [
                'user_id' => $user27,
                'organization_id' => $org4,
                'position'=>'President',
                'role' => 'Moderator',
            ],

        ];

        foreach($orgusers as $i){
            OrganizationUser::create($i);
        }

        // DB::table('organization_user')->insert($orgusers);

        $this->command->info('ORGANIZATION_USER generated.');

    

       

       
    }
    
}
