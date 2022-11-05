@php
    $hasPendingForms = $myForms->isNotEmpty();   
@endphp
<x-app-layout>
    @if(Helper::isFormCreated())
    <div x-data="initialize_local_data()"></div>
    @endif

    <!-- Alert Message For adding, editing, and deleting org member -->
    <x-alert-message/> 

    {{-- If there's no pending form --}}
    @if(!$hasPendingForms)
    <div class="mt-14 h-auto w-full rounded-sm px-6 py-4">
        <div class="flex flex-col justify-center items-center py-16 px-2 md:px-8">
            <img class="w-auto h-auto sm:h-96 object-cover" src="{{ asset('assets/img/no-pending-form.png')}}" alt="No Pending Forms"/>
            <div class="text-center space-y-3 mt-6">
                <h1 class="text-2xl text-bland-500 font-bold tracking-wide">No Pending Form! 📣 </h1>
                <p class="text-sm text-bland-400">Looks like nothing to see here. </p>
            </div>
        </div>
    </div>
    @else
    {{-- If there's pending form --}} 
    <div x-data="{cancelForm: false, modal:true}">
        <div class="py-24"> 
            <div class="max-w-screen mx-auto px-4 lg:px-8">
                <div class="bg-white mt-4 h-auto w-full rounded-sm shadow-sm px-6 py-4">
                    <div class="flex items-center mb-2">
                        <x-svg width="w-7" height="h-7" color="fill-bland-600">
                            <path d="M17 22q-2.075 0-3.537-1.462Q12 19.075 12 17q0-2.075 1.463-3.538Q14.925 12 17 12t3.538 1.462Q22 14.925 22 17q0 2.075-1.462 3.538Q19.075 22 17 22Zm1.675-2.625.7-.7L17.5 16.8V14h-1v3.2ZM5 21q-.825 0-1.413-.587Q3 19.825 3 19V5q0-.825.587-1.413Q4.175 3 5 3h4.175q.275-.875 1.075-1.438Q11.05 1 12 1q1 0 1.788.562.787.563 1.062 1.438H19q.825 0 1.413.587Q21 4.175 21 5v6.25q-.45-.325-.95-.55-.5-.225-1.05-.4V5h-2v3H7V5H5v14h5.3q.175.55.4 1.05.225.5.55.95Zm7-16q.425 0 .713-.288Q13 4.425 13 4t-.287-.713Q12.425 3 12 3t-.712.287Q11 3.575 11 4t.288.712Q11.575 5 12 5Z"/>
                        </x-svg>
                        <p class="text-bland-600">Your Pending Forms:</p>
                    </div>

                    <hr>

                    {{-- Legend --}}
                    <div class="flex flex-wrap sm:space-x-3 mt-2">
                        
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-green-200 rounded-full"></div><p class="text-xs text-bland-400">Activity Proposal Form</p>
                        </div>

                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-blue-200 rounded-full"></div><p class="text-xs text-bland-400">Budget Requisition Form</p>
                        </div>

                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-yellow-200 rounded-full"></div><p class="text-xs text-bland-400">Narrative Report</p>
                        </div>

                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-rose-200 rounded-full"></div><p class="text-xs text-bland-400">Liquidation Form</p>
                        </div>

                    </div>


                    <!-- Accordion -->
                    <div x-data="inputChecker()" @load.window="addEventTitle('{{ $myForms }}')" >
                        <ul class="mt-4">   
                        @foreach($myForms as $form)
                        @php
                            if($form->form_type === 'APF'){
                                $bg = "broder border-green-200 bg-green-100  rounded-md px-1";
                            }
                            if($form->form_type === 'BRF'){
                                $bg = "border border-blue-200 bg-blue-100 rounded-md px-1";
                            }
                            if($form->form_type === 'NR'){
                                $bg = "border border-yellow-200 bg-yellow-100 rounded-md px-1";
                            }
                            if($form->form_type === 'LF'){
                                $bg = "border border-rose-200 bg-rose-100 rounded-md px-1";
                            }
                        @endphp
                            <li class="mt-1 border shadow-sm border-bland-100 first:rounded-t-lg last:rounded-b-lg">
                                <div x-data="{ open: false, pickerOpen: true}">
                                    <div class="h-auto grid grid-flow-row auto-rows-max px-8 py-4 cursor-pointer border border-bland-100 shadow-sm lg:grid-cols-4" @click="open = !open">
                                        <p class="text-sm text-bland-600"> <span class="font-bold">Event Title: </span> <span class="{{ $bg }}">{{ $form->event_title }}</span></p> 
                                        <p class="text-sm text-bland-600"> <span class="font-bold">Organization: </span>{{ $form->myOrg->getOrgName->org_name }}</p>
                                        <p class="text-sm text-bland-600"> <span class="font-bold">Current Approver: </span>{{ $form->curr_approver }}</p>
                                        <p class="flex text-sm text-bland-600"> <span class="font-bold mr-1">Status: </span> {{ $form->status }} 
                                           @if($form->status === "Denied" && auth()->user()->checkOrgRole('Moderator|Editor', $form->organization_id))
                                           <a href="{{ route('forms.edit.show', ['forms' => $form->id]) }}"  @click="setTimeout(() => { open = false}, 1)">
                                                <x-svg color="fill-primary-blue" marginRight="ml-2" class="cursor-pointer hover:fill-semantic-info">
                                                    <path d="M5 23.7q-.825 0-1.413-.588Q3 22.525 3 21.7v-14q0-.825.587-1.413Q4.175 5.7 5 5.7h8.925l-2 2H5v14h14v-6.95l2-2v8.95q0 .825-.587 1.412-.588.588-1.413.588Zm7-9Zm4.175-8.425 1.425 1.4-6.6 6.6V15.7h1.4l6.625-6.625 1.425 1.4-7.2 7.225H9v-4.25Zm4.275 4.2-4.275-4.2 2.5-2.5q.6-.6 1.438-.6.837 0 1.412.6l1.4 1.425q.575.575.575 1.4T22.925 8Z"/>
                                                </x-svg>
                                           </a>
                                            @endif
                                        </p>
                                    </div>

                                    <!-- Accordion Body -->
                                    <div x-cloak x-transition 
                                        x-show="open" 
                                        class="bg-white border-2 border-t-0 mt-1 border-bland-100 px-8">
                                        <!-- Accordion Body Top -->
                                        <div class="py-4 space-y-2">
                                            <div class="grid grid-cols-2">
                                                <p class="text-sm text-bland-600"> <span class="font-bold">Submitted By: </span>{{$form->fromOrgUser->fromUser->first_name}} {{$form->fromOrgUser->fromUser->last_name}}</p>
                                                <p class="text-sm text-bland-600"> <span class="font-bold">Date Submitted: </span>{{\Carbon\Carbon::parse($form->created_at)->format('F d, Y - h:i A') }}</p>
                                            </div>
                                            <div class="grid grid-cols-2">
                                                <p class="text-sm text-bland-600"> <span class="font-bold">Target Date: </span>{{\Carbon\Carbon::parse($form->target_date)->format('F d, Y') }}</p>
                                                <p class="text-sm text-bland-600"> <span class="font-bold">Control Number: </span>{{ $form->control_number }} </p>
                                                
                                            </div>
                                        </div>          

                                        <hr>
                                        <!-- Accordion Body Bottom -->
                                        <!-- Tracker -->
                                        @if($form->form_type === 'NR')
                                        <x-tracker orientation="vertical">
                                            <x-tracker-item orientation="vertical" approver="Adviser" dateApproved="{{ $form->adviser_date_approved ? \Carbon\Carbon::parse($form->adviser_date_approved)->format('F d, Y - h:i A') : null }}"/>
                                            <x-tracker-item orientation="vertical" approver="SAO Head" dateApproved="{{ $form->sao_date_approved ? \Carbon\Carbon::parse($form->sao_date_approved)->format('F d, Y - h:i A') : null }}"/>
                                        </x-tracker>
                                        @elseif($form->form_type === 'LF')
                                        <x-tracker orientation="vertical">
                                            <x-tracker-item orientation="vertical" approver="Adviser" dateApproved="{{ $form->adviser_date_approved ? \Carbon\Carbon::parse($form->adviser_date_approved)->format('F d, Y - h:i A') : null }}"/>
                                            <x-tracker-item orientation="vertical" approver="Finance and Accounting Head" dateApproved="{{ $form->finance_date_approved ? \Carbon\Carbon::parse($form->finance_date_approved)->format('F d, Y - h:i A') : null }}"/>
                                        </x-tracker>
                                        @else
                                        <x-tracker orientation="vertical">
                                            <x-tracker-item orientation="vertical" approver="Adviser" dateApproved="{{ $form->adviser_date_approved ? \Carbon\Carbon::parse($form->adviser_date_approved)->format('F d, Y - h:i A') : null }}"/>
                                            <x-tracker-item orientation="vertical" approver="SAO Head" dateApproved="{{ $form->sao_date_approved ? \Carbon\Carbon::parse($form->sao_date_approved)->format('F d, Y - h:i A') : null }}"/>
                                            <x-tracker-item orientation="vertical" approver="Academic Services Head" dateApproved="{{ $form->acadserv_date_approved ? \Carbon\Carbon::parse($form->acadserv_date_approved)->format('F d, Y - h:i A') : null }}"/>
                                            <x-tracker-item orientation="vertical" approver="Finance and Accounting Head" dateApproved="{{ $form->finance_date_approved ? \Carbon\Carbon::parse($form->finance_date_approved)->format('F d, Y - h:i A') : null }}"/>
                                        </x-tracker>
                                        @endif

                                        <!-- cancelForm Button && View Details -->
                                        <div class="flex justify-end space-x-2 my-4">
                                         
                                            <x-button onclick="window.location='{{ route('submitted-forms.show', ['forms' => $form->id ]) }}'">
                                                {{__('View Details')}}
                                            </x-button>

                                            <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="cancelForm = true,  modal= true, setId('{{ $form->id }}'), clearInputField()">
                                                {{__('Cancel')}}
                                            </x-button>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>

                        {{-- Cancel form modal --}}
                        <x-modal name="cancelForm" width="w-[600px]">
                            <form action="{{ route('dashboard.cancel') }}" method="POST">
                                @csrf 
                                <template x-if="id">
                                    <div class="text-sm py-5 leading-relaxed">
                                        Cancelling your form process is irreversible. Enter the event title of your form <br>
                                        (<span x-text="getEventTitle" class="bg-bland-200 font-bold text-bland-400 rounded-md border-2 border-bland-500"></span>) below to confirm you want to permanently cancel it:
                                        <x-input id="checker" class="mt-4 w-full px-2" type="text" name="checker" x-ref="inputField" required autofocus autocomplete="off" @keyup="checkInput($el)" />
                                    </div>
                                </template>
                            
                                <div class="flex justify-end space-x-2">          
                                    <input type="hidden" id="formId" name="formId" x-ref="formId">
                                    <x-button bg="bg-semantic-success" hover="hover:bg-green-600" @click="cancelForm = false, modal=false">
                                        {{ __('Back') }}
                                    </x-button>

                                    {{-- Custom button --}}
                                    <x-custom-button type="button" x-ref="button">
                                        Confirm
                                    </x-custom-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>




