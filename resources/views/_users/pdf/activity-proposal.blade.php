<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title></title>

        <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
                margin: 0px;
                padding: 0px;
                font-size: 14px;
            }
            .logo {
                text-align: center;
                padding-top: 80px;
            }
            .logo .apcLogo {
                width: 150px;
                height: 150px;
            }
            .frontPageH1 {
                text-align: center;
                padding-top: 70px;
            }
            .apcText {
                text-align: center;
                font-size: 24px;
                padding-top: 92px;
            }
            .formType {
                text-align: center;
                font-size: 32px;
                padding-top: 32px;
            }
            .submittedBy {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
                padding-top: 220px;
            }
            .submittedBy p{
                text-align: center;
                font-size: 16px;
                font-weight: normal;
            }
            .preparedBy {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
                padding-top: 50px;
            }
            .preparedBy p{
                text-align: center;
                font-size: 16px;
                font-weight: normal;
            }
            .page-break {
                page-break-after: always;
            }
            .row1 .row1Table {
                width: 100%;
                table-layout: fixed;
                padding: 16px 24px;
            }
            .row1 .row1Table td {
                padding: 8px 8px;
            }
            .row2 .row2Table {
                width: 100%;
                table-layout: fixed;
                padding: 16px 24px;
            }
            .row2 .row2Table td {
                padding: 8px 8px;
            }
            .row3 {
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row3 .coorganizer {
                font-size: 28px;
                padding-bottom: 16px;
            }
            .row3 .row3Table {
                width: 100%;
                table-layout: fixed;
                padding: 16px 24px;
                background-color: #E9E9E9;
            }
            .row3 .row3Table td {
                padding-top: 10px;
            }
            .row4 {
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row4 .row4Table {
                width: 100%;
                table-layout: fixed;
                padding: 16px 24px;
            }
            .row4 .row4Table td {
                padding: 10px 10px;
            }
            .row5 .row5Table {
                width: 100%;
                table-layout: fixed;
                padding: 16px 24px;
            }
            .row5 .row5Table td {
                padding: 10px 10px;
            }
            .row6 {
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row6 .programs{
                font-size: 28px;
                padding-bottom: 16px;
            }
            .row6Table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            .row6Table td, .row6Table th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .row6Table tr:nth-child(even){
                background-color: #f2f2f2;
            }
            .row6Table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #e6b800;
                color: black;
            }
            .row7 .requests{
                font-size: 28px;
                padding-top: 24px;
                padding-bottom: 16px;
            }
            .row7Table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            .row7Table td, .row7Table th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .row7Table tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            .row7Table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #e6b800;
                color: black;
            }
            .row8 {
            padding-top: 100px;
            }
            .row8Table {
                font-family: Arial, Helvetica, sans-serif;
                width: 100%;
                table-layout: fixed;
            }
            .row8Table td, .row8Table th { 
                padding: 8px;
            }
            .row9 {
            padding-top: 32px;
            }
            .row9Table {
                font-family: Arial, Helvetica, sans-serif;
                width: 100%;
                table-layout: fixed;
            }
            .row9Table td, .row9Table th { 
                padding: 8px;
            }
        </style>
    </head>
    <body>
        <div class="main-container">
            <div class="logo">
                <img class="apcLogo" src="{{public_path('assets/img/apc-logo.png')}}" alt="">
            </div>
            <h1 class="frontPageH1">
                Student Activities Office's Online Event Creation <br> System
            </h1>
            <div class="apcText">
                Asia Pacific College
            </div>
            <div class="formType">
                Activity Proposal Form
            </div>
            <div class="submittedBy">
                Submitted By: <br> 
                <!-- organization-->
                <p>{{$form->fromOrguser()->first()->fromUser()->first()->first_name}} {{$form->fromOrguser()->first()->fromUser()->first()->last_name}}</p>
                
            </div>
            <div class="preparedBy">
                Organization:
                <!--Prepared By-->
                <p>{{$form->myOrg->getOrgName->org_name}}</p>
            </div>

            <!--PAGE BREAK-->
            <div class="page-break"></div>

            <!--Section 1-->
            <div class="row1">
                <table class="row1Table">
                    <thead>
                    </thead>
                    <tbody>  
                        <tr>
                            <!--Event Title-->
                            <td class="eventTitle"><b>Event Title: </b>{{$form->event_title}}</td>
                            <!--Date Submitted-->
                            <td class="dateSubmitted"><b>Date Submitted: </b>{{date('M d, Y', strtotime($form->created_at))}}</td>
                        </tr>
                        <tr>
                            <!--Duration of event-->
                            <td class="eventDuration"><b>Duration of Event: </b>{{$proposal->duration_val}} {{$proposal->duration_unit}}</td>
                            <!--Target Date of Event-->
                            <td class="eventDateTarget"><b>Target Date of Event: </b>{{date('M d, Y', strtotime($form->target_date))}}</td> 
                        </tr>
                        <tr>
                            <!--Activity Classification-->
                            <td class="actClassification"><b>Activity Classification: </b>{{$proposal->classification($proposal->act_classification)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <!--Section 2-->
            <div class="row2">
                <table class="row2Table">
                    <thead>
                    </thead>
                    <tbody>  
                        <tr>
                            <!--Organizer Name-->
                            <td class="organizerName"><b>Organizer Name: </b>{{$proposal->getOrganizerInfo->fromUser->first_name}} {{$proposal->getOrganizerInfo->fromUser->last_name}}</td>
                            <!--Organizer email-->
                            <td class="email"><b>Email: </b>{{$proposal->getOrganizerInfo->fromUser->email}}</td>
                        </tr>
                        <tr>
                            <!--Organization-->
                            <td class="organization"><b>Organization: </b>{{$form->myOrg->getOrgName->org_name}}</td>
                            <!--Organizer contact number-->
                            <td class="contactNumber"><b>Contact Number: </b>{{$form->fromOrgUser->fromUser->phone_number}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="row5">
                <table class="row5Table">
                    <thead>
                    </thead>
                    <tbody>  
                        <tr>
                            <!--Description-->
                            <td class="description"><b>Description: </b>{{$proposal->description}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <hr>

            <!--Section 3-->
            <div class="row3">
                <div class="coorganizer">
                    Co-Organizer
                </div>
                <!--Table: Coorganizers-->
                <table class="row3Table">
                    <thead>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($coorganizers as $coorg)  
                        <tr>
                            {{$i++}} 
                            <!--Organizer Name-->
                            <td class="organizerName"><b>Co-Organizer: </b>{{$coorg->coorganizer}}</td>
                            <!--Organizer email-->
                            <td class="email"><b>Email: </b>{{$coorg->email}} </td>
                        </tr>
                        <tr class="tableRow2">
                            <!--Organization-->
                            <td class="organization"><b>Co-Organization: </b>{{$coorg->coorganization}}</td>
                            <!--Organizer contact number-->
                            <td class="contactNumber"><b>Contact Number: </b>{{$coorg->phone_number}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    
            <hr>

            <!--Section 4-->
            <div class="row4">
                <table class="row4Table">
                    <thead>
                    </thead>
                    <tbody>  
                        <tr>
                            <!--Primary Target-->
                            <td class="primaryTarget"><b>Primary Target Participants/Audience: </b>{{$proposal->primary_audience}}</td>
                            <!--Num Primary Target-->
                            <td class="numberofPrimary"><b>Number of Primary Participants/Audience: </b>{{$proposal->num_primary_audience}}</td>
                        </tr>
                        <tr>
                            <!--Secondary Target-->
                            <td class="secondaryTarget"><b>Secondary Target Participants/Audience: </b>{{$proposal->secondary_audience}}</td>
                            <!--Num Secondary Target-->
                            <td class="numberofSecondary"><b>Number of Secondary Participants/Audience: </b>{{$proposal->num_secondary_audience}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <!--Section 5-->
            <div class="row5">
                <table class="row5Table">
                    <thead>
                    </thead>
                    <tbody>  
                        <tr>
                            <!--Rationale-->
                            <td class="rationale"><b>Rationale: </b>{{$proposal->rationale}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>
    
            <div class="row5">
                <table class="row5Table">
                    <thead>
                    </thead>
                    <tbody>  
                        <tr>
                            <!--Outcome-->
                            <td class="rationale"><b>Outcome: </b>{{$proposal->outcome}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <!--Section 6-->
            <div class="row6">
                <div class="programs">
                    Programs
                </div>
                <table class="row6Table">
                    <thead>
                        <th>Activity</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach($prePrograms as $program)  
                        <tr>
                            {{$i++}}
                            <!--Activity-->
                            <td class="activity">{{$program->activity}}</td>
                            <!--Start Date-->
                            <td class="startDate">{{date('M d, Y  h:i A', strtotime($program->start_date_time))}}</td>
                            <!--End Date-->
                            <td class="endDate">{{date('M d, Y  h:i A', strtotime($program->end_date_time))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        
            <!--Section 7-->
            <div class="row7">
                <div class="requests">
                    Requests
                </div>
                <table class="row7Table">
                    <thead>
                        <th>Items/Service/Support</th>
                        <th>Date Needed</th>
                        <th>Venue</th>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach($requests as $logistic)  
                        <tr>
                            {{$i++}}
                            <!--Service-->
                            <td class="service">{{$logistic->service}}</td>
                            <!--Date Needed-->
                            <td class="dateNeeded">{{date('M d, Y ', strtotime($logistic->date_needed))}}</td>
                            <!--Venue-->
                            <td class="venue">{{$logistic->venue}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


            <!--Approvers-->
            <div class="row8">
                <table class="row8Table">
                    <thead>
                        
                    </thead>
                    <tbody>
                        <tr>                  
                            <!--Adviser-->
                            <td class="adviser">Adviser: <b>{{$form->getFormAdviser()->first()->fromUser()->first()->first_name}} {{$form->getFormAdviser()->first()->fromUser()->first()->last_name}}</b></td>
                            <!--SAO Head-->
                            <td class="sao">SAO Head: <b>{{$form->getFormSao()->first()->staffUser()->first()->first_name }} {{$form->getFormSao()->first()->staffUser()->first()->last_name}}</b></td>
                        </tr>
                        <tr>
                            <td class="approvedDate">Approved Date: <b>{{date('M d, Y ', strtotime($form->adviser_date_approved))}}</b></td>
                            <td class="approvedDate">Approved Date: <b>{{date('M d, Y ', strtotime($form->sao_date_approved))}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row9">
                <table class="row9Table">
                    <thead>
                        
                    </thead>
                    <tbody>
                        <tr>                  
                            <!--Acad Serv Head-->
                            <td class="acadServ">Academic Services Head: <b>{{$form->getFormAcadServ()->first()->staffUser()->first()->first_name}} {{$form->getFormAcadServ()->first()->staffUser()->first()->last_name}}</b></td>
                            <!--Finance Head-->
                            <td class="finance">Finance Head: <b>{{$form->getFormFinance()->first()->staffUser()->first()->first_name}} {{$form->getFormFinance()->first()->staffUser()->first()->last_name}}</b></td>
                        </tr>
                        <tr>
                            <td class="approvedDate">Approved Date: <b>{{date('M d, Y ', strtotime($form->acadserv_date_approved))}}</b></td>
                            <td class="approvedDate">Approved Date: <b>{{date('M d, Y ', strtotime($form->finance_date_approved))}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>