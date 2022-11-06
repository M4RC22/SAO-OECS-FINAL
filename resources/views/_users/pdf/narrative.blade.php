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
                padding: 16px 24px 0px 0px;
            }
            .row1 .row1Table td {
                padding: 8px 8px;
            }
            .row2 .row2Table {
                width: 100%;
                table-layout: fixed;
                padding: 16px 24px 0px 0px;
                overflow-wrap: break-word;
            }
            .row2 .row2Table td {
                padding: 8px 8px;
            }
            .row3 {
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row3 .programs{
                font-size: 28px;
                padding-bottom: 16px;
            }
            .row3Table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            .row3Table td, .row3Table th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .row3Table tr:nth-child(even){
                background-color: #f2f2f2;
            }
            .row3Table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #e6b800;
                color: black;
            }
            .row4 {
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row4 .participants{
                font-size: 28px;
                padding-bottom: 16px;
            }
            .row4Table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            .row4Table td, .row4Table th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .row4Table tr:nth-child(even){
                background-color: #f2f2f2;
            }
            .row4Table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #e6b800;
                color: black;
            }
            .row5 {
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row5 .officialPoster{
                font-size: 28px;
                padding-bottom: 16px;
            }
            .row5 img {
                width: 200px;
                height: 200px;
            }
            .row5 .row5Table {
                width: 100%;
                height: 50%;
                padding: 16px 24px 0px 0px;
            }
            .row5 .row5Table td {
                padding: 8px 8px;
            }
            .row6 {
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row6 .eventImages{
                font-size: 28px;
                padding-bottom: 16px;
            }
            .row6 img {
                width: 200px;
                height: 200px;
            }
            .row6 .row6Table {
                width: 100%;
                height: 25%;
                padding: 16px 24px 0px 0px;
            }
            .row6 .row6Table td {
                padding: 8px 8px;
            }
            .row7 {
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row7 .suggestions{
                font-size: 28px;
                padding-bottom: 16px;
            }
            .row7 .row7Table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                table-layout: fixed;
                overflow-wrap: break-word;
            }
            .row7Table td, .row7Table th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .row7Table tr:nth-child(even){
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
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row8 .comments{
                font-size: 28px;
                padding-bottom: 16px;
            }
            .row8 .row8Table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                table-layout: fixed;
                overflow-wrap: break-word;
            }
            .row8Table td, .row8Table th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .row8Table tr:nth-child(even){
                background-color: #f2f2f2;
            }
            .row8Table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #e6b800;
                color: black;
            }
            .row9 .row9Table {
                width: 100%;
                table-layout: fixed;
                padding: 16px 24px 0px 0px;
            }
            .row9 .row9Table td {
                padding: 8px 8px;
            }
            .row10 {
                padding-top: 100px;
            }
            .row10Table {
                font-family: Arial, Helvetica, sans-serif;
                width: 100%;
                table-layout: fixed;
            }
            .row10Table td, .row10Table th { 
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
                Narrative Report
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
                            <!--Narration-->
                            <td class="narration"><b>Narration: </b>{{$narrative->narration}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <!--Section 3-->
            <div class="row3">
                <div class="programs">
                    Programs
                </div>
                <!--Table: Programs-->
                <table class="row3Table">
                    <thead>
                        <th>Activity</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($postPrograms as $program)  
                        <tr>
                            {{$i++}} 
                            <!--Activity-->
                            <td class="activity">{{$program->activity}}</td>
                            <!--Start Date-->
                            <td class="startDate">{{date('M d, Y', strtotime($program->start_date))}}</td>
                            <!--End Date-->
                            <td class="endDate">{{date('M d, Y', strtotime($program->end_date))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!--Section 4-->
            <div class="row4">
                <div class="participants">
                    Participants
                </div>
                <!--Table: Programs-->
                <table class="row4Table">
                    <thead>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Section</th>
                        <th>Participated Date</th>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($participants as $participant)  
                        <tr>
                            {{$i++}} 
                            <!--First Name-->
                            <td class="firstName">{{$participant->first_name}}</td>
                            <!--Last Name-->
                            <td class="lastName">{{$participant->last_name}}</td>
                            <!--Section-->
                            <td class="section">{{$participant->section}}</td>
                            <!--Participated Date-->
                            <td class="participatedDate">{{date('M d, Y', strtotime($participant->participated_date))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <hr>

            <!--Section 5-->
            <div class="row5">
                <div class="officialPoster">
                    Official Poster
                </div>
                <table class="row5Table">
                    <thead>
                    </thead>
                    <tbody> 
                        <tr>
                        @foreach($images as $image)
                        @if($image->image_type === 'poster')  
                            <td><img src="{{public_path('storage/'.$image->url)}}"></td>
                        @endif
                        @endforeach
                        </tr>
                    </tbody>
                </table>         
            </div>
            

            <!--Section 6-->
            <div class="row6">
                <div class="eventImages">
                    Event Images
                </div>
                <table class="row6Table">
                    <thead>
                    </thead>
                    <tbody> 
                        <tr>
                        @foreach($images as $image)
                        @if($image->image_type === 'photo') 
                           <td><img src="{{public_path('storage/'.$image->url)}}"></td>
                        @endif
                        @endforeach
                        </tr>
                    </tbody>
                </table>         
            </div>

            <hr>

            <!--Section 7-->
            <div class="row7">
                <div class="suggestions">
                    Suggestions
                </div>
                <!--Table: Suggestions-->
                <table class="row7Table">
                    <thead>
                        <th>Message</th>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($commentSuggestions as $comment)
                        @if($comment->type === 'suggestion')
                        <tr>
                            {{$i++}} 
                            <!--Message-->
                            <td class="message">{{$comment->message}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!--Section 8-->
            <div class="row8">
                <div class="comments">
                    Comments
                </div>
                <!--Table: Comments-->
                <table class="row8Table">
                    <thead>
                        <th>Message</th>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($commentSuggestions as $comment)
                        @if($comment->type === 'comment')
                        <tr>
                            {{$i++}} 
                            <!--Message-->
                            <td class="message">{{$comment->message}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!--Section 9-->
            <div class="row9">
                <table class="row9Table">
                    <thead>
                    </thead>
                    <tbody>  
                        <tr>
                            <!--Rating-->
                            <td class="rating"><b>Rating: </b>{{$narrative->ratings}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!--Approvers-->
            <div class="row10">
                <table class="row10Table">
                    <thead>
                        
                    </thead>
                    <tbody>
                        <tr>                  
                            <!--Adviser-->
                            <td class="adviser">Adviser: <b>{{$form->getFormAdviser()->first()->fromUser()->first()->first_name}} {{$form->getFormAdviser()->first()->fromUser()->first()->last_name}}</b></td>
                            <!--SAO Head-->
                            <td class="sao">SAO Head: <b>{{$form->getFormSao()->first()->staffUser()->first()->first_name}} {{$form->getFormSao()->first()->staffUser()->first()->last_name}}</b></td>
                        </tr>
                        <tr>
                            <td class="approvedDate">Approved Date: <b>{{date('M d, Y ', strtotime($form->adviser_date_approved))}}</b></td>
                            <td class="approvedDate">Approved Date: <b>{{date('M d, Y ', strtotime($form->sao_date_approved))}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>