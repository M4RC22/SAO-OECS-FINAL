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
            .row2 {
                padding-top: 24px;
                padding-bottom: 24px;
            }
            .row2 .items{
                font-size: 28px;
                padding-bottom: 16px;
            }
            .row2Table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            .row2Table td, .row2Table th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .row2Table tr:nth-child(even){
                background-color: #f2f2f2;
            }
            .row2Table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #e6b800;
                color: black;
            }
            .row3 {
                padding-top: 100px;
            }
            .row3Table {
                font-family: Arial, Helvetica, sans-serif;
                width: 100%;
                table-layout: fixed;
            }
            .row3Table td, .row3Table th { 
                padding: 8px;
            }
            .row4 {
            padding-top: 32px;
            }
            .row4Table {
                font-family: Arial, Helvetica, sans-serif;
                width: 100%;
                table-layout: fixed;
            }
            .row4Table td, .row4Table th { 
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
                Budget Requisition Form
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
                            <!--Type-->
                            <td class="type"><b>Type: </b>{{$requisition->payment}}</td>
                             <!--Date Needed-->
                            <td class="dateNeeded"><b>Date Needed: </b>{{date('M d, Y ', strtotime($requisition->date_needed))}}</td> 
                        </tr>
                        <tr>
                            <!--Charged Department-->
                            <td class="chargedDepartment"><b>Charged Department: </b>{{$requisition->getDepartment()->first()->name}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <!--Section 2-->
            <div class="row2">
                <div class="items">
                    Items
                </div>
                <!--Table: Items-->
                <table class="row2Table">
                    <thead>
                        <th>Particulars/Purpose</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </thead>
                    <tbody>
                    @php $i = 1; $total = 0; @endphp
                    @foreach($items as $item)  
                        <tr>
                            {{$i++}} 
                            <!--Particulars-->
                            <td class="particulars">{{$item->purposes}}</td>
                            <!--Quantity-->
                            <td class="qty">{{$item->quantity}}</td>
                            <!--Price-->
                            <td class="price">{{$item->price}}</td>
                        </tr>
                    @php $total += $item->price * $item->quantity @endphp
                    @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td><b>Total: </b>{{ $total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!--Approvers-->
            <div class="row3">
                <table class="row3Table">
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

            <div class="row4">
                <table class="row4Table">
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