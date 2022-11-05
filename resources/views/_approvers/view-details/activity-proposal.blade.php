@php 
    $isStudent = auth()->user()->checkUserType('Student');
@endphp
<x-app-layout>
    <div x-data="{denyForm: false, modal:false}" class="py-24"> 
        <div x-data="{approveForm: false, modal:false}" class="max-w-screen mx-auto px-4 lg:px-8">
            <div class="flex justify-between flex-wrap">
                <h1 class="flex items-center text-xl">
                    <span>
                        <x-svg width="w-7" height="w-7" color="fill-bland-600">
                            <path d="M6 22q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h8l6 6v4h-2V9h-5V4H6v16h6v2Zm0-2V4v16Zm12.3-5.475 1.075 1.075-3.875 3.85v1.05h1.05l3.875-3.85 1.05 1.05-4.3 4.3H14v-3.175Zm3.175 3.175L18.3 14.525l1.45-1.45q.275-.275.7-.275.425 0 .7.275l1.775 1.775q.275.275.275.7 0 .425-.275.7Z"/>
                        </x-svg>
                    </span> 
                    Activity Proposal Form
                </h1>
            </div>
   
            @if(!$isStudent)
            <!-- Tracker large Screen -->
            <div class="py-4 hidden xl:block">
                <x-tracker orientation="horizontal">
                    <x-tracker-item orientation="horizontal" approver="Adviser" dateApproved="{{$forms->adviser_date_approved ? \Carbon\Carbon::parse($forms->adviser_date_approved)->format('M d, Y') : null}}"/>
                    <x-tracker-item orientation="horizontal" approver="SAO Head" dateApproved="{{$forms->sao_date_approved ? \Carbon\Carbon::parse($forms->sao_date_approved)->format('M d, Y') : null}}"/>
                    <x-tracker-item orientation="horizontal" approver="Academic Services Head" dateApproved="{{$forms->acadserv_date_approved ? \Carbon\Carbon::parse($forms->acadserv_date_approved)->format('M d, Y') : null}}"/>
                    <x-tracker-item orientation="horizontal" approver="Finance and Accounting Head" dateApproved="{{$forms->finance_date_approved ? \Carbon\Carbon::parse($forms->finance_date_approved)->format('M d, Y') : null}}"/>
                </x-tracker>
            </div>
            @endif

            <hr class="mt-3">
            <div class="bg-white mt-4 h-auto w-full rounded-sm shadow-sm px-6 py-4">
                
                {{-- Row #1 --}}
                <div class="grid grid-flow-row auto-rows-max gap-6 mt-4 md:grid-cols-4">
                       <p class="text-bland-600 font-bold">Event Title: <span class="font-normal"> {{$forms->event_title}}</span></p>
                       <p class="text-bland-600 font-bold md:col-start-4">Date Submitted: <span class="font-normal">{{date('M d, Y', strtotime($forms->created_at))}}</span></p> 
                </div>

                {{-- Row #2 --}}
                <div class="grid grid-flow-row auto-rows-max gap-6 mt-4 md:grid-cols-4">
                    <p class="text-bland-600 font-bold">Duration of Event: <span class="font-normal">  {{$proposal->duration_val}} {{$proposal->duration_unit}}</span></p>
                    <p class="text-bland-600 font-bold md:col-start-4">Target Date of Event: <span class="font-normal">  {{date('M d, Y', strtotime($forms->target_date))}} </span></p>
                </div>

                {{-- Row #3 --}}
                <div class="grid grid-flow-row auto-rows-max gap-6 mt-4 md:grid-cols-1 mb-4">
                    <p class="text-bland-600 font-bold">Activity Classification: <span class="font-normal">  {{$proposal->classification($proposal->act_classification)}} </span></p>
                </div>

                <hr class="my-8">

                {{-- Row #4 --}}
                <div class="grid grid-flow-row auto-rows-max gap-6 mt-4 md:grid-cols-4">
                    <p class="text-bland-600 font-bold">Organizer: <span class="font-normal">  {{$proposal->getOrganizerInfo->fromUser->first_name}} {{$proposal->getOrganizerInfo->fromUser->last_name}} </span></p>
                    <p class="text-bland-600 font-bold md:col-start-4">Organization: <span class="font-normal">  {{$forms->myOrg->getOrgName->org_name}} </span></p>
                </div>

                {{-- Row #5 --}}
                <div class="grid grid-flow-row auto-rows-max gap-6 mt-4 md:grid-cols-4 mb-4">
                    <p class="text-bland-600 font-bold col-span-2">Email: <span class="font-normal">  {{$proposal->getOrganizerInfo->fromUser->email}} </span></p>
                    <p class="text-bland-600 font-bold md:col-start-4">Contact Number: <span class="font-normal">  {{$forms->fromOrgUser->fromUser->phone_number}} </span></p>
                </div>

                <hr class="my-8">

                {{-- Row #6 --}}
                <div class="flex my-4 space-x-2">
                    <p class="text-bland-600 font-bold" >Description: </p>
                    <p> {{$proposal->description}} </p>
                </div>

                
                <hr class="mt-8 mb-4">

                {{-- Row #7 --}}
                <h1 class="text-lg text-bland-600 font-bold my-4">Coorganizers</h1>
                <div class="bg-white mt-4 h-auto w-full border-b border-gray-200 shadow-sm">
                    <div id="participant-container" class="overflow-auto block max-h-[420px] rounded-sm scroll-smooth">
                        <table class="table-auto w-full border-collapse border text-left">
                
                            {{-- Table Head--}}
                            <thead class="border-b bg-bland-200 sticky top-0 z-10">
                                {{-- Insert Table Head Columns Here --}}
                                <x-table.head-col>#</x-table.head-col>
                                <x-table.head-col>Co-Organization</x-table.head-col>
                                <x-table.head-col>Co-organizer</x-table.head-col>
                                <x-table.head-col>Contact Number</x-table.head-col>
                                <x-table.head-col>Email</x-table.head-col>
                                {{-- Table Head Columns Ends Here --}}
                            </thead>
                            {{-- Table Body --}}
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($externalCoorganizers as $coorg)
                                
                                <tr class="bg-white  hover:bg-bland-100 border-b border-bland-20">
                                    <x-table.body-col>
                                        <p class="pl-2"> {{$i++}} </p>
                                    </x-table.body-col>
                                    <x-table.body-col>
                                        <p class="pl-2"> {{$coorg->coorganization}} </p>
                                    </x-table.body-col>
                                    <x-table.body-col>
                                        <p class="pl-2"> {{$coorg->coorganizer}} </p>
                                    </x-table.body-col>
                                    <x-table.body-col>
                                        <p class="pl-2"> {{$coorg->phone_number}} </p>
                                    </x-table.body-col>
                                    <x-table.body-col>
                                        <p class="pl-2"> {{$coorg->email}} </p>
                                    </x-table.body-col>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Row #8 --}}
                <h1 class="text-lg text-bland-600 font-bold my-4">Programs</h1>
                <div class="bg-white mt-4 h-auto w-full border-b border-gray-200 shadow-sm">
                    <div id="participant-container" class="overflow-auto block max-h-[420px] rounded-sm scroll-smooth">
                        <table class="table-auto w-full border-collapse border text-left">
                
                            {{-- Table Head--}}
                            <thead class="border-b bg-bland-200 sticky top-0 z-10">
                                {{-- Insert Table Head Columns Here --}}
                                <x-table.head-col>#</x-table.head-col>
                                <x-table.head-col>Activity</x-table.head-col>
                                <x-table.head-col>Start Date</x-table.head-col>
                                <x-table.head-col>End Date</x-table.head-col>
                                {{-- Table Head Columns Ends Here --}}
                            </thead>
                            {{-- Table Body --}}
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($prePrograms as $program)
                                <tr class="bg-white  hover:bg-bland-100 border-b border-bland-20">
                                    <x-table.body-col><p class="pl-2"> {{$i++}} </p></x-table.body-col>
                                    <x-table.body-col><p class="pl-2"> {{$program->activity}} </p></x-table.body-col> 
                                    <x-table.body-col><p class="pl-2"> {{date('M d, Y  h:i A', strtotime($program->start_date_time))}} </p></x-table.body-col>
                                    <x-table.body-col><p class="pl-2"> {{date('M d, Y  h:i A', strtotime($program->end_date_time))}} </p></x-table.body-col>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Row #9 --}}
                <h1 class="text-lg text-bland-600 font-bold my-4">Logistical Needs</h1>
                <div class="bg-white mt-4 h-auto w-full border-b border-gray-200 shadow-sm">
                    <div id="participant-container" class="overflow-auto block max-h-[420px] rounded-sm scroll-smooth">
                        <table class="table-auto w-full border-collapse border text-left">
                
                            {{-- Table Head--}}
                            <thead class="border-b bg-bland-200 sticky top-0 z-10">
                                {{-- Insert Table Head Columns Here --}}
                                <x-table.head-col>#</x-table.head-col>
                                <x-table.head-col>Items/Service/Support</x-table.head-col>
                                <x-table.head-col>Date Needed</x-table.head-col>
                                <x-table.head-col>Venue</x-table.head-col>
                                {{-- Table Head Columns Ends Here --}}
                            </thead>
                            {{-- Table Body --}}
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($logisticalNeeds as $logistic)
                                <tr class="bg-white  hover:bg-bland-100 border-b border-bland-20">
                                    <x-table.body-col>
                                        <p class="pl-2">{{$i++}} </p>
                                    </x-table.body-col>
                                    <x-table.body-col>
                                        <p class="pl-2">{{$logistic->service}} </p>
                                    </x-table.body-col>
                                    <x-table.body-col>
                                        <p class="pl-2">{{date('M d, Y ', strtotime($logistic->date_needed))}} </p>
                                    </x-table.body-col>
                                    <x-table.body-col>
                                        <p class="pl-2">{{$logistic->venue}} </p>
                                    </x-table.body-col>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="my-8">

                {{-- Row #10 --}}
                <div class="grid grid-flow-row auto-rows-max gap-6 mt-6 md:grid-cols-4 mb-6">
                    <p class="text-bland-600 font-bold col-span-2">Primary Target Audience/Beneficiary: <span class="font-normal">  {{$proposal->primary_audience}} </span></p>
                    <p class="text-bland-600 font-bold col-span-2 md:col-start-3">Number of Primary Participants/Beneficiary: <span class="font-normal">   {{$proposal->num_primary_audience}} </span></p>
                </div>

                {{-- Row #11 --}}
                <div class="grid grid-flow-row auto-rows-max gap-6 mt-4 md:grid-cols-4 mb-4">
                    <p class="text-bland-600 font-bold col-span-2">Secondary Target Audience/Beneficiary: <span class="font-normal">  {{$proposal->secondary_audience}} </span></p>
                    <p class="text-bland-600 font-bold col-span-2 md:col-start-3">Number of Secnodary Participants/Beneficiary: <span class="font-normal">  {{$proposal->num_secondary_audience}} </span></p>
                </div>

                <hr class="my-8">

                {{-- Row #12 --}}
                <div class="flex my-4 space-x-2">
                    <p class="text-bland-600 font-bold">Rationale: </p>
                    <p> {{$proposal->rationale}} </p>
                </div>

                <hr class="my-8">

                {{-- Row #13 --}}
                <div class="flex my-4 space-x-2">
                    <p class="text-bland-600 font-bold">Outcome: </p>
                    <p> {{$proposal->outcome}} </p>
                </div>

                @if(!$isStudent)
                <hr class="my-8">

                <div class="mt-8 mb-2">

                    <x-button  bg="bg-semantic-success" hover="hover:bg-green-600" type="button" class="px-8" @click="approveForm = true, modal = true">
                        {{ __('Approve') }}
                    </x-button>

                    <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" type="button" class="px-8" @click="denyForm = true, modal = true">
                        {{ __('Deny') }}
                    </x-button>
                   
                </div>

                <!-- Tracker Small Screen-->
                <div class="py-4 block xl:hidden">
                    <x-tracker orientation="vertical">
                        <x-tracker-item orientation="vertical" approver="Adviser" dateApproved="{{$forms->adviser_date_approved ? \Carbon\Carbon::parse($forms->adviser_date_approved)->format('M d, Y') : null}}"/>
                        <x-tracker-item orientation="vertical" approver="SAO Head" dateApproved="{{$forms->sao_date_approved ? \Carbon\Carbon::parse($forms->sao_date_approved)->format('M d, Y') : null}}"/>
                        <x-tracker-item orientation="vertical" approver="Academic Services Head" dateApproved="{{$forms->acadserv_date_approved ? \Carbon\Carbon::parse($forms->acadserv_date_approved)->format('M d, Y') : null}}"/>
                        <x-tracker-item orientation="vertical" approver="Finance and Accounting Head" dateApproved="{{$forms->finance_date_approved ? \Carbon\Carbon::parse($forms->finance_date_approved)->format('M d, Y') : null}}"/>
                    </x-tracker>
                </div>
                @endif


            </div>

            {{-- Approve Modal --}}
            <x-view-details.approve id="{{!! $forms->id !!}}" eventTitle="{{!! $forms->event_title !!}}" orgName="{{!! $forms->myOrg->getOrgName->org_name !!}}" formType="{{!! $forms->form_type !!}}" />

            {{-- Deny Modal --}}
            <x-view-details.deny id="{{!! $forms->id !!}}" eventTitle="{{!! $forms->event_title !!}}" formType="{{!! $forms->form_type !!}}" />

        </div>
    </div>
</x-app-layout>












 {{-- <forms action="{{ route('submitted-forms.deny', ['forms' => $forms->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-input id="remarks" class="mt-1 w-full" type="text" name="remarks" autofocus/>

                        <x-button class="px-12" bg="bg-semantic-danger" hover="hover:bg-rose-600" type="submit">
                            {{ __('Deny') }}
                        </x-button>
                    </forms> --}}