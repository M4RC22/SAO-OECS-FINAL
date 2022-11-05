@php
    $isModeratorOrEditor = Auth::user()->checkRole('Moderator|Editor');
    $encodedOrgList = json_encode($authOrgList);
    $encodedMembersList = json_encode($members);
@endphp
<x-app-layout>
    <!-- Error Mesage -->
    <x-alert-message/>
    
    @if(!$isModeratorOrEditor)
    <div class="mt-8 h-auto w-full rounded-sm px-6 py-4">
        <div class="flex flex-col justify-center items-center py-16 px-2 md:px-8">
            <img class="w-auto h-auto sm:h-96 object-cover" src="{{ asset('assets/img/restricted.png')}}" alt="No Forms Pending"/>
            <div class="text-center space-y-3 mt-6">
                <h1 class="text-2xl text-bland-500 font-bold tracking-wide">Authorized Users Only! 🚫 </h1>
                <p class="text-sm text-bland-400">Sorry, but you don't have permission to access this page. </p>
            </div>
        </div>
    </div>
    @else
    <div class="py-24" x-data="set_local_storage_data('apf')"> {{-- apf = Activity Proposal Form --}}
        <div class="max-w-screen mx-auto px-4 lg:px-8" x-data="get_local_storage_data('apf')">
            <div class="flex justify-between flex-wrap">
                <h1 class="flex items-center text-xl">
                    <span>
                        <x-svg width="w-7" height="w-7" color="fill-bland-600">
                            <path d="M6 22q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h8l6 6v4h-2V9h-5V4H6v16h6v2Zm0-2V4v16Zm12.3-5.475 1.075 1.075-3.875 3.85v1.05h1.05l3.875-3.85 1.05 1.05-4.3 4.3H14v-3.175Zm3.175 3.175L18.3 14.525l1.45-1.45q.275-.275.7-.275.425 0 .7.275l1.775 1.775q.275.275.275.7 0 .425-.275.7Z"/>
                        </x-svg>
                    </span> 
                    Activity Proposal Form
                </h1>
                <x-button @click="clear_form_local_storage('apf', true), loading(true)">
                    <x-svg>
                        <path d="M11 20.95q-3.025-.375-5.012-2.638Q4 16.05 4 13q0-1.65.65-3.163Q5.3 8.325 6.5 7.2l1.425 1.425q-.95.85-1.437 1.975Q6 11.725 6 13q0 2.2 1.4 3.887 1.4 1.688 3.6 2.063Zm2 0v-2q2.175-.4 3.587-2.075Q18 15.2 18 13q0-2.5-1.75-4.25T12 7h-.075l1.1 1.1-1.4 1.4-3.5-3.5 3.5-3.5 1.4 1.4-1.1 1.1H12q3.35 0 5.675 2.325Q20 9.65 20 13q0 3.025-1.987 5.288Q16.025 20.55 13 20.95Z"/>
                    </x-svg>
                    {{ __('Reset') }}
                </x-button>
            </div>
            <hr class="mt-3">
            <div class="bg-white mt-4 h-auto w-full rounded-sm shadow-sm px-6 py-4">
                <form action="{{ route('forms.activity-proposal.store') }}" method="POST">
                    @csrf
                    {{-- Row #1 --}}
                    <div class="grid grid-flow-row auto-rows-max gap-6 md:grid-cols-3">

                        {{-- Target date of event --}}
                        <div>
                            <x-label for="target_date" :value="__('Target Date of Event')" />

                            <x-input id="target_date" class="mt-1 w-full" type="date" name="target_date" required autofocus @change="storeInput($el)" />
                            @error('target_date')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                        
                        {{-- Duration of Event--}}
                        <div>
                            <x-label for="duration_val" :value="__('Duration of Event')" />
                            
                            <div class="flex space-x-4">
                                {{-- Number of Days --}}
                                <x-input id="duration_val" class="mt-1 w-full" type="number" min="1" name="duration_val" required autofocus @keyup="storeInput($el)" />
                                @error('duration_val')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror

                                

                                {{-- Duration unit --}}
                                <x-select class="mt-1" id="duration_unit" name="duration_unit" aria-label="Default select example" @change="storeInput($el)">
                                    <option value="day(s)" selected >Day(s)</option>
                                    <option value="weeks(s)">Weeks(s)</option>
                                    <option value="months(s)">Month(s)</option>
                                </x-select>
                                @error('duration_unit')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror

                            </div>

                        </div>

                        {{-- Venue --}}
                        <div>
                            <x-label for="venue" :value="__('Venue')" />
                            
                            <x-input id="venue" class="mt-1 w-full" type="text" name="venue" required autofocus @keyup="storeInput($el)"/>
                            @error('venue')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                    </div>


                    {{-- Row #2 --}}
                    <div x-data="populateOrganizer()" @load.window="loadOrgs('{{  $encodedOrgList }}'), loadMembers('{{  $encodedMembersList }}')" class="grid grid-flow-row auto-rows-max gap-6 mt-4 md:grid-cols-3">

                        {{-- Event Title --}}
                        <div>
                            <x-label for="event_title" :value="__('Event Title')" />

                            <x-input id="event_title" class="mt-1 w-full" type="text" name="event_title" required autofocus @keyup="storeInput($el)" />
                            @error('event_title')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                        {{-- Name of organization --}}
                        <div>
                            <x-label for="org_id" :value="__('Organization Name')" />
                            <x-select class="mt-1" id="org_id" name="org_id" aria-label="Default select example" required x-ref="organization" @change="storeInput($el), populateMembers($el)">
                                <option value='' disabled selected>--select option--</option>
                                @foreach($authOrgList as $org)
                                <option value="{{$org->id}}">{{$org->org_name}}</option>
                                @endforeach
                            </x-select>
                            @error('org_id')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                        {{-- Name of organizer --}}
                        <div>
                            <x-label for="organizer_organization_user_id" :value="__('Name of Organizer')" />
                            <x-select class="mt-1" id="organizer_organization_user_id" name="organizer_organization_user_id" aria-label="Default select example" required x-ref="members" @change="storeInput($el)">
                                <option value='' disabled selected>--select option--</option>
                            </x-select>
                            @error('organizer_organization_user_id')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                    </div>

                    {{-- row #3 --}}
                    <div class="grid grid-flow-row auto-rows-max gap-6 mt-4 md:grid-cols-3">

                        {{-- Activity Classification --}}
                        <div>
                            <x-label for="act_classification" :value="__('Activity Classification')" />

                            <x-select class="mt-1" id="act_classification" name="act_classification" aria-label="Default select example" @change="storeInput($el)">
                                <option value='' disabled selected>--select option--</option>
                                <option value="t1">CSR/Community Service</option>
                                <option value="t2">Games/Competition</option>
                                <option value="t3">Marketing</option>
                                <option value="t4">Social Event/Party/Celebration</option>
                                <option value="t5">Workshop/Seminar/Training/Symposium/Forum/Team Building</option>
                            </x-select>
                            @error('act_classification')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                        {{-- Activity Location --}}
                        <div>
                            <x-label for="act_location" :value="__('Activity Location')" />

                            <x-select class="mt-1" id="act_location" name="act_location" aria-label="Default select example" @change="storeInput($el)">
                                <option value='' disabled selected>--select option--</option>
                                <option value="In-Campus">In-Campus</option>
                                <option value="Off-Campus">Off-Campus</option>
                            </x-select>
                            @error('act_location')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                    </div>

                    {{-- Row #4 Coorganizer Table --}}
                    <hr class="mt-6 border-1 border-bland-300">

                    <h1 class="text-lg text-bland-600 font-bold my-4">Coorganizers</h1>
                    
                    <input type="hidden" name="coorganizers" x-ref="coorganizers">
                    <div x-data="coorganizer_handler()" @load.window="onLoad()">
                        <x-table.main>
                            {{-- Table Head--}}
                            <x-table.head>
                                {{-- Insert Table Head Columns Here --}}
                                <x-table.head-col>Co-Organization</x-table.head-col>
                                <x-table.head-col>Co-Organizer</x-table.head-col>
                                <x-table.head-col>Contact Number</x-table.head-col>
                                <x-table.head-col class="pr-24">Email</x-table.head-col>
                                <x-table.head-col class="text-center">Action</x-table.head-col>
                                {{-- Table Head Columns Ends Here --}}
                            </x-table.head>
                            {{-- Table Body --}}
                            <tbody>
                                <template x-for="(field, index) in coorganizers[0]" :key="index">
                                    <tr class="bg-white  hover:bg-bland-100">
                                        {{-- Insert Table Body Columns Here --}}
                                        <x-table.body-col>
                                            <x-input x-model="field.coorganization"  id="coorganization" class="mt-1 w-full" type="text" name="coorganization[]" readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col>
                                            <x-input x-model="field.name" id="coorganizer_name" class="mt-1 w-full" type="text" name="coorganizer_name[]" readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col>
                                            <x-input x-model="field.phone" id="coorganizer_phone" class="mt-1 w-full" type="tel" name="coorganizer_phone[]" readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col>
                                            <x-input x-model="field.email" id="coorganizer_email" class="mt-1 w-full" type="email" name="coorganizer_email[]" readonly autofocus/>
                                        </x-table.body-col>
                                        <x-table.body-col class="text-center px-1">
                                            <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="removeCoorganizer(index)">
                                                {{ __('Remove') }}
                                            </x-button>
                                        </x-table.body-col>
                                        {{-- Table Body Columns Ends Here --}}
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot class="border-t border-bland-200">
                                <tr>
                                    {{-- Insert Table Footer Columns Here --}}
                                    <x-table.footer-col>
                                        <x-select x-model="newCoorganizers[0].coorganization" class="mt-1 w-full"  class="mt-1" id="act_location" name="act_location" aria-label="Default select example">
                                            <option selected disabled value="">--select option--</option>
                                            <option value="External">External</option>
                                            <option value="Internal">Internal</option>
                                        </x-select>
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newCoorganizers[0].name" class="mt-1 w-full" type="text" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newCoorganizers[0].phone" class="mt-1 w-full" type="tel" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newCoorganizers[0].email" class="mt-1 w-full" type="email" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col class="text-center">
                                        <x-button @click="addCoorganizer">
                                            {{ __('Add Row') }}
                                        </x-button>
                                    </x-table.footer-col>
                                    {{-- Table Footer Columns Ends Here --}}
                                </tr>
                            </tfoot>
                        </x-table.main>
                        <span x-show="error" class="flex text-sm text-semantic-danger font-light">*<p x-text="msg"></p></span>
                        @error('coorganizers')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                    </div>

                    {{-- Row #5 Logistic Table --}}
                    <hr class="mt-6 border-1 border-bland-300">

                    <h1 class="text-lg text-bland-600 font-bold my-4">Requests</h1>

                    <input type="hidden" name="requests" x-ref="logistics">
                    <div x-data="logistic_handler()" @load.window="onLoad()">
                        <x-table.main>
                            {{-- Table Head--}}
                            <x-table.head>
                                {{-- Insert Table Head Columns Here --}}
                                <x-table.head-col>Items/Service/Support</x-table.head-col>
                                <x-table.head-col>Date Needed</x-table.head-col>
                                <x-table.head-col>Venue</x-table.head-col>
                                <x-table.head-col class="text-center">Action</x-table.head-col>
                                {{-- Table Head Columns Ends Here --}}
                            </x-table.head>
                            {{-- Table Body --}}
                            <tbody>
                                <template x-for="(field, index) in logistics[0]" :key="index">
                                    <tr class="bg-white  hover:bg-bland-100">
                                        {{-- Insert Table Body Columns Here --}}
                                        <x-table.body-col>
                                            <x-input x-model="field.service"  id="service" class="mt-1 w-full" type="text" name="service[]" readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col>
                                            <x-input x-model="field.date_needed" id="logistics_date_needed" class="mt-1 w-full" type="date" name="logistics_date_needed[]" readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col>
                                            <x-input x-model="field.venue" id="logistics_venue" class="mt-1 w-full" type="tel" name="logistics_venue[]" readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col class="text-center">
                                            <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="removeLogistic(index)">
                                                {{ __('Remove') }}
                                            </x-button>
                                        </x-table.body-col>
                                        {{-- Table Body Columns Ends Here --}}
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot class="border-t border-bland-200">
                                <tr>
                                    {{-- Insert Table Footer Columns Here --}}
                                    <x-table.footer-col>
                                        <x-input x-model="newLogistics[0].service" class="mt-1 w-full" type="text" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newLogistics[0].date_needed" class="mt-1 w-full" type="date" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newLogistics[0].venue" class="mt-1 w-full" type="text" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col class="text-center">
                                        <x-button @click="addLogistic">
                                            {{ __('Add Row') }}
                                        </x-button>
                                    </x-table.footer-col>
                                    {{-- Table Footer Columns Ends Here --}}
                                </tr>
                            </tfoot>
                        </x-table.main>
                        <span x-show="error" class="flex text-sm text-semantic-danger font-light">*<p x-text="msg"></p></span>
                        @error('requests')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                    </div>

                    {{-- Row #6 --}}
                    <div class="mt-2">
                        <x-label for="description" :value="__('Description')" />

                        <x-text-area id="description" name="description" @keyup="storeInput($el)"></x-text-area>
                        @error('description')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                    </div>

                    {{-- Row #7 --}}
                    <div class="mt-2">
                        <x-label for="rationale" :value="__('Rationale')" />

                        <x-text-area id="rationale" name="rationale" @keyup="storeInput($el)"></x-text-area>
                        @error('rationale')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                    </div>

                    {{-- Row #8 --}}
                    <div class="mt-2">
                        <x-label for="outcome" :value="__('Outcome')" />

                        <x-text-area id="outcome" name="outcome"  @keyup="storeInput($el)"></x-text-area>
                        <span class="text-xs text-bland-400 font-light italic">*If it is classified as a Workshop/Training/Seminar/Symposium/Forum/Team Building, Learning outcomes or objective should be written here</span>
                        @error('outcome')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                    </div>

                    

                    {{-- Row #9 --}}
                    <div class="grid grid-flow-row auto-rows-max gap-6 mt-6 md:grid-cols-3">

                        {{-- Primary Target Audience/Beneficiary --}}
                        <div>
                            <x-label for="primary_audience" :value="__('Primary Target Participants/Audience')" />

                            <x-input id="primary_audience" class="mt-1 w-full" type="text" name="primary_audience" required autofocus @keyup="storeInput($el)"/>
                            @error('primary_audience')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror

                        </div>


                        {{-- Number of Participants/Audience --}}
                        <div >
                            <x-label for="num_primary_audience" :value="__('Number of Primary Participants/Audience')" />
                            
                            <x-input id="num_primary_audience" class="mt-1 w-full" type="number" min="0" name="num_primary_audience" required autofocus @keyup="storeInput($el)"/>
                            @error('num_primary_audience')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                    </div>

                    {{-- Row #10 --}}
                    <div class="grid grid-flow-row auto-rows-max gap-6 mt-2 md:grid-cols-3">

                        {{-- Sesecondary Target Audience/Beneficiary --}}
                        <div>
                            <x-label for="secondary_audience" :value="__('Secondary Target Participants/Audience')" />

                            <x-input id="secondary_audience" class="mt-1 w-full" type="text" name="secondary_audience" required autofocus @keyup="storeInput($el)"/>
                            @error('secondary_audience')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>


                        {{-- Number of Participants/Audience --}}
                        <div>
                            <x-label for="num_secondary_audience" :value="__('Number of Secondary Participants/Audience')" />
                            
                            <x-input id="num_secondary_audience" class="mt-1 w-full" type="number" min="0" name="num_secondary_audience" required autofocus @keyup="storeInput($el)"/>
                            @error('num_secondary_audience')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                    </div>

                     {{-- Row #11 Coorganizer Table --}}
                     <hr class="mt-6 border-1 border-bland-300">

                     <h1 class="text-lg text-bland-600 font-bold my-4">Programs</h1> 
                     
                     {{-- Programs/Activites --}}

                     <input type="hidden" name="programs" x-ref="activities">
                     <div x-data="activity_handler()" @load.window="onLoad()">
                         <x-table.main>
                             {{-- Table Head--}}
                             <x-table.head>
                                 {{-- Insert Table Head Columns Here --}}
                                 <x-table.head-col>Activity</x-table.head-col>
                                 <x-table.head-col>Start Date</x-table.head-col>
                                 <x-table.head-col>End Date</x-table.head-col>
                                 <x-table.head-col class="text-center">Action</x-table.head-col>
                                 {{-- Table Head Columns Ends Here --}}
                             </x-table.head>
                             {{-- Table Body --}}
                             <tbody>
                                 <template x-for="(field, index) in activities[0]" :key="index">
                                     <tr class="bg-white  hover:bg-bland-100">
                                         {{-- Insert Table Body Columns Here --}}
                                         <x-table.body-col>
                                             <x-input x-model="field.activity"  id="activity" class="mt-1 w-full" type="text" name="activity[]"  readonly autofocus />
                                         </x-table.body-col>
                                         <x-table.body-col>
                                             <x-input x-model="field.start_date" id="start_date" class="mt-1 w-full" type="datetime-local" name="start_date[]"  readonly autofocus />
                                         </x-table.body-col>
                                         <x-table.body-col>
                                             <x-input x-model="field.end_date" id="end_date" class="mt-1 w-full" type="datetime-local" name="end_date[]" readonly autofocus />
                                         </x-table.body-col>
                                         <x-table.body-col class="text-center">
                                             <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="removeActivity(index)">
                                                 {{ __('Remove') }}
                                             </x-button>
                                         </x-table.body-col>
                                         {{-- Table Body Columns Ends Here --}}
                                     </tr>
                                 </template>
                             </tbody>
                             <tfoot class="border-t border-bland-200">
                                 <tr>
                                     {{-- Insert Table Footer Columns Here --}}
                                     <x-table.footer-col>
                                         <x-input x-model="newActivities[0].activity" class="mt-1 w-full" type="text" autofocus />
                                     </x-table.footer-col>
                                     <x-table.footer-col>
                                         <x-input x-model="newActivities[0].start_date" class="mt-1 w-full" type="datetime-local" autofocus />
                                     </x-table.footer-col>
                                     <x-table.footer-col>
                                         <x-input x-model="newActivities[0].end_date" class="mt-1 w-full" type="datetime-local" autofocus />
                                     </x-table.footer-col>
                                     <x-table.footer-col class="px-1 text-center">
                                         <x-button @click="addActivity()">
                                             {{ __('Add Row') }}
                                         </x-button>
                                     </x-table.footer-col>
                                     {{-- Table Footer Columns Ends Here --}}
                                 </tr>
                             </tfoot>
                         </x-table.main>
                         <span x-show="error" class="flex text-sm text-semantic-danger font-light">*<p x-text="msg"></p></span>
                         @error('programs')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                     </div>

                     {{-- Important Notes --}}
                     <hr class="mt-6 border-1 border-bland-300">
                     <div class="text-xs text-bland-400 font-light italic">
                        <br>1. The Activity Proposal Form must be submitted at least two (2) weeks before the event.
                        <br>2. Activities will not be approved if its date/s falls one (1) week before the midterms or final exams, or if its date falls exactly on the midterms or finals week. Activities with dates falling on term break will be approved provided that participants will be required to submit waivers.
                        <br>3. It is the responsibility of the organization to inquire and prepare for the logistical needs and follow them up after the approval of their proposal.
                    </div>

                    <div class="mt-8">
                        <x-button type="submit" class="px-12">
                            {{ __('Submit') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>












