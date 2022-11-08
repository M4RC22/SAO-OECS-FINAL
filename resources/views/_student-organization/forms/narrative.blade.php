@php
    $isModeratorOrEditor = Auth::user()->checkRole('Moderator|Editor');
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
    <div class="py-24" x-data="set_local_storage_data('nr')"> {{-- nr = Narrative Report --}}
        <div class="max-w-screen mx-auto px-4 lg:px-8" x-data="get_local_storage_data('nr')">
            <div class="flex justify-between flex-wrap">
                <h1 class="flex items-center text-xl">
                    <span>
                        <x-svg width="w-7" height="w-7" color="fill-bland-600">
                            <path d="M8 20q-.825 0-1.412-.587Q6 18.825 6 18v-3h3v-2.25q-.875-.05-1.662-.388-.788-.337-1.438-1.012v-1.1H4.75L1.5 7q.9-1.15 2.225-1.625Q5.05 4.9 6.4 4.9q.675 0 1.313.1.637.1 1.287.375V4h12v13q0 1.25-.875 2.125T18 20Zm3-5h6v2q0 .425.288.712.287.288.712.288t.712-.288Q19 17.425 19 17V6h-8v.6l6 6V14h-1.4l-2.85-2.85-.2.2q-.35.35-.738.625-.387.275-.812.425ZM5.6 8.25h2.3v2.15q.3.2.625.275.325.075.675.075.575 0 1.038-.175.462-.175.912-.625l.2-.2-1.4-1.4q-.725-.725-1.625-1.088Q7.425 6.9 6.4 6.9q-.5 0-.95.075-.45.075-.9.225ZM8 18h7.15q-.075-.225-.112-.475Q15 17.275 15 17H8Zm0 0v-1 1Z"/>
                        </x-svg>
                    </span> 
                    Narrative Report
                </h1>
                <x-button @click="clear_form_local_storage('nr', true), loading(true)">
                    <x-svg>
                        <path d="M11 20.95q-3.025-.375-5.012-2.638Q4 16.05 4 13q0-1.65.65-3.163Q5.3 8.325 6.5 7.2l1.425 1.425q-.95.85-1.437 1.975Q6 11.725 6 13q0 2.2 1.4 3.887 1.4 1.688 3.6 2.063Zm2 0v-2q2.175-.4 3.587-2.075Q18 15.2 18 13q0-2.5-1.75-4.25T12 7h-.075l1.1 1.1-1.4 1.4-3.5-3.5 3.5-3.5 1.4 1.4-1.1 1.1H12q3.35 0 5.675 2.325Q20 9.65 20 13q0 3.025-1.987 5.288Q16.025 20.55 13 20.95Z"/>
                    </x-svg>
                    {{ __('Reset') }}
                </x-button>
            </div>

            <hr class="mt-3">
            <div class="bg-white mt-4 h-auto w-full rounded-sm shadow-sm px-6 py-4">
                <form action="{{ route('forms.narrative.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Row #1 --}}               
                    <div class="grid grid-flow-row auto-rows-max gap-6 md:grid-cols-2">

                         {{-- Event Title --}}
                         <div>
                            <x-label for="event_id" :value="__('Event Title')" />

                            <x-select class="mt-1" id="event_id" name="event_id" aria-label="Default select example" @change="storeInput($el)">
                                <option value='' selected disabled>--select option--</option>
                                @foreach($eventList as $event)
                                <option value="{{$event->event_id}}">{{$event->event_title}}</option>
                                @endforeach
                            </x-select>
                            @error('event_id')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>


                        {{-- Date Venue --}}
                        <div>
                            <x-label for="venue" :value="__('Venue')" />
                            
                            <x-input id="venue" class="mt-1 w-full" type="text" name="venue" required autofocus @keyup="storeInput($el)"/>
                            @error('venue')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                    </div>

                    {{-- Row #2 --}}          
                    <div class="mt-2">
                        <x-label for="narration" :value="__('Narration')" />

                        <x-text-area id="narration" name="narration" required @keyup="storeInput($el)"></x-text-area>
                        @error('narration')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                    </div>


                    {{-- Row #3 Program Table --}}
                    <hr class="mt-6 border-1 border-bland-300">

                    <h1 class="text-lg text-bland-600 font-bold my-4">Programs</h1>

                    <input type="hidden" name="programs" x-ref="programs">
                    <div x-data="program_handler()" @load.window="onLoad()">
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
                                <template x-for="(field, index) in programs[0]" :key="index">
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
                                            <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="removeProgram(index)">
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
                                        <x-input x-model="newPrograms[0].activity" class="mt-1 w-full" type="text" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newPrograms[0].start_date" class="mt-1 w-full" type="datetime-local" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newPrograms[0].end_date" class="mt-1 w-full" type="datetime-local" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col class="px-1 text-center" @click=addProgram>
                                        <x-button>
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


                    {{-- Row #4 Participants Table --}}
                    <hr class="mt-6 border-1 border-bland-300">

                    <div x-data="participant_handler()" @load.window="onLoad()">

                        <div class="flex justify-between items-end mt-4">

                            <h1 class="text-lg text-bland-600 font-bold">Participants</h1>

                        </div>
                    
                        {{-- Custom table --}}
                        <input type="hidden" name="participants" x-ref="participants">
                        <div class="bg-white mt-4 h-auto w-full border-b border-gray-200 shadow-sm">
                            <div id="participant-container" class="overflow-auto block max-h-[420px] rounded-sm scroll-smooth">
                                <table class="table-auto w-full border-collapse border text-left">
                        
                                    {{-- Table Head--}}
                                    <thead class="border-b bg-bland-200 sticky top-0 z-10">
                                        {{-- Insert Table Head Columns Here --}}
                                        <x-table.head-col>First Name</x-table.head-col>
                                        <x-table.head-col>Last Name</x-table.head-col>
                                        <x-table.head-col>Section</x-table.head-col>
                                        <x-table.head-col>Participated Date</x-table.head-col>
                                        <x-table.head-col class="text-center">Action</x-table.head-col>
                                        {{-- Table Head Columns Ends Here --}}
                                    </thead>
                                    {{-- Table Body --}}
                                    <tbody>
                                        <template x-for="(field, index) in participants[0]" :key="index">
                                            <tr class="bg-white hover:bg-bland-100 w-full transition duration-300 ease-in-out">
                                                {{-- Insert Table Body Columns Here --}}
                                                <x-table.body-col>
                                                    <x-input x-model="field.first_name"  id="first_name" class="mt-1 w-full" type="text" name="first_name[]"  readonly autofocus />
                                                </x-table.body-col>
                                                <x-table.body-col>
                                                    <x-input x-model="field.last_name" id="last_name" class="mt-1 w-full" type="text" name="last_name[]"  readonly autofocus />
                                                </x-table.body-col>
                                                <x-table.body-col>
                                                    <x-input x-model="field.section" id="section" class="mt-1 w-full" type="text" name="section[]" readonly autofocus />
                                                </x-table.body-col>
                                                <x-table.body-col>
                                                <x-input x-model="field.participated_date" id="participated_date" class="mt-1 w-full" type="date" name="participated_date[]" readonly autofocus />
                                            </x-table.body-col>
                                                <x-table.body-col class="text-center">
                                                    <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="removeParticipant(index)">
                                                        {{ __('Remove') }}
                                                    </x-button>
                                                </x-table.body-col>
                                                {{-- Table Body Columns Ends Here --}}
                                            </tr>
                                        </template>
                                    </tbody>
                                    <tfoot class="border-t border-bland-200 bg-white sticky bottom-0">
                                        <tr>
                                            {{-- Insert Table Footer Columns Here --}}
                                            <x-table.footer-col>
                                                <x-input x-model="newParticipants[0].first_name" class="mt-1 w-full" type="text" autofocus />
                                            </x-table.footer-col>
                                            <x-table.footer-col>
                                                <x-input x-model="newParticipants[0].last_name" class="mt-1 w-full" type="text" autofocus />
                                            </x-table.footer-col>
                                            <x-table.footer-col>
                                                <x-input x-model="newParticipants[0].section" class="mt-1 w-full" type="text" autofocus />
                                            </x-table.footer-col>
                                            <x-table.footer-col>
                                            <x-input x-model="newParticipants[0].participated_date" class="mt-1 w-full" type="date" autofocus />
                                        </x-table.footer-col>
                                            <x-table.footer-col class="px-1 text-center">
                                                <x-button @click="addParticipant">
                                                    {{ __('Add Row') }}
                                                </x-button>
                                            </x-table.footer-col>
                                            {{-- Table Footer Columns Ends Here --}}
                                        </tr>
                                    </tfoot>
                        
                                </table>
                            </div>
                        </div>
                        <span x-show="error" class="flex text-sm text-semantic-danger font-light">*<p x-text="msg"></p></span>
                        @error('participants')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror

                    
                        <div class="flex justify-end mt-2">

                            <x-button>
                                
                                <x-svg>
                                    <path d="M6 20q-.825 0-1.412-.587Q4 18.825 4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413Q18.825 20 18 20Zm5-4V7.85l-2.6 2.6L7 9l5-5 5 5-1.4 1.45-2.6-2.6V16Z"/>
                                </x-svg>
                                {{ __('Upload CSV') }}

                                <input 
                                    type="file" 
                                    name="participants_csv" 
                                    id="participants_csv" 
                                    accept=".csv"
                                    class="absolute cursor-pointer right-0 opacity-0"
                                    @change="readCSV, loading(true)"
                                >

                            </x-button>
                        </div>

                    </div>
                   

                    {{-- Row #6 --}}
                    <hr class="mt-6 border-1 border-bland-300">

            
                    <!-- Official Poster -->
                    <div x-data="singleUpload()" x-cloak class="w-full">
                        <div class="mt-4">

                            <h1 class="text-lg text-bland-600 font-bold">Official Poster</h1>

                            <div class="mb-3 w-full">
                                <div class="flex bg-blue-100 py-4 px-2 my-2 rounded-sm">
                                    <x-svg width="w-4" height="w-4" color="fill-blue-700" marginRight="mr-1">
                                        <path d="M11 17h2v-6h-2Zm1-8q.425 0 .713-.288Q13 8.425 13 8t-.287-.713Q12.425 7 12 7t-.712.287Q11 7.575 11 8t.288.712Q11.575 9 12 9Zm0 13q-2.075 0-3.9-.788-1.825-.787-3.175-2.137-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175 1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138 1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175-1.35 1.35-3.175 2.137Q14.075 22 12 22Zm0-2q3.35 0 5.675-2.325Q20 15.35 20 12q0-3.35-2.325-5.675Q15.35 4 12 4 8.65 4 6.325 6.325 4 8.65 4 12q0 3.35 2.325 5.675Q8.65 20 12 20Zm0-8Z"/>
                                    </x-svg>
                                    <p class="text-xs font-bold text-blue-700">You can only upload a single file with file extension of JPG, PNG and JPEG</p>
                                </div>
                                <input class="form-control block w-96 px-3 py-1.5 my-4 font-normal text-sm text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" name="official_poster" accept="image/*" id="imgSelect" x-ref="singleFile" @change="previewFile" >
                            </div>
                        </div>

                        <div class="bg-gray-200 py-2 px-2 mt-2 rounded-sm">
                            <div class="flex">
                                <x-svg width="w-4" height="w-4" color="fill-gray-500" marginRight="mr-1">
                                    <path d="M11.5 22q-2.3 0-3.9-1.6T6 16.5V6q0-1.65 1.175-2.825Q8.35 2 10 2q1.65 0 2.825 1.175Q14 4.35 14 6v9.5q0 1.05-.725 1.775Q12.55 18 11.5 18q-1.05 0-1.775-.725Q9 16.55 9 15.5V6h1.5v9.5q0 .425.288.712.287.288.712.288t.713-.288q.287-.287.287-.712V6q0-1.05-.725-1.775Q11.05 3.5 10 3.5q-1.05 0-1.775.725Q7.5 4.95 7.5 6v10.5q0 1.65 1.175 2.825Q9.85 20.5 11.5 20.5q1.65 0 2.825-1.175Q15.5 18.15 15.5 16.5V6H17v10.5q0 2.3-1.6 3.9T11.5 22Z"/>
                                </x-svg>
                                <p class="text-xs font-bold text-gray-500">File</p>
                            </div>
                    
                            <template x-if="imgsrc">
                                <p x-text="fileName" class="text-sm text-blue-600 cursor-pointer mt-4 hover:underline"  @click="window.open(imgsrc)"> </p>
                            </template>
           
                        </div>

                    </div>

                    <!-- Event Images -->
                    <div x-data="multipleUpload()" x-cloak class="w-full">
                        <div class="mt-12">

                            <h1 class="text-lg text-bland-600 font-bold">Event Images</h1>

                            <div class="mb-3 w-full">
                                <div class="flex bg-blue-100 py-4 px-2 my-2 rounded-sm">
                                    <x-svg width="w-4" height="w-4" color="fill-blue-700" marginRight="mr-1">
                                        <path d="M11 17h2v-6h-2Zm1-8q.425 0 .713-.288Q13 8.425 13 8t-.287-.713Q12.425 7 12 7t-.712.287Q11 7.575 11 8t.288.712Q11.575 9 12 9Zm0 13q-2.075 0-3.9-.788-1.825-.787-3.175-2.137-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175 1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138 1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175-1.35 1.35-3.175 2.137Q14.075 22 12 22Zm0-2q3.35 0 5.675-2.325Q20 15.35 20 12q0-3.35-2.325-5.675Q15.35 4 12 4 8.65 4 6.325 6.325 4 8.65 4 12q0 3.35 2.325 5.675Q8.65 20 12 20Zm0-8Z"/>
                                    </x-svg>
                                    <p class="text-xs font-bold text-blue-700">You can upload multiple file with file extension of JPG, PNG and JPEG</p>
                                </div>
                                <input class="form-control block w-96 px-3 py-1.5 my-4 font-normal text-sm text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" name="event_images[]" accept="image/*" id="imgSelect" x-ref="multipleFile" @change="previewFile" multiple >
                            </div>
                        </div>

                        <div class="bg-gray-200 py-2 px-2 mt-2 rounded-sm border">
                            <div class="flex">
                                <x-svg width="w-4" height="w-4" color="fill-gray-500" marginRight="mr-1">
                                    <path d="M11.5 22q-2.3 0-3.9-1.6T6 16.5V6q0-1.65 1.175-2.825Q8.35 2 10 2q1.65 0 2.825 1.175Q14 4.35 14 6v9.5q0 1.05-.725 1.775Q12.55 18 11.5 18q-1.05 0-1.775-.725Q9 16.55 9 15.5V6h1.5v9.5q0 .425.288.712.287.288.712.288t.713-.288q.287-.287.287-.712V6q0-1.05-.725-1.775Q11.05 3.5 10 3.5q-1.05 0-1.775.725Q7.5 4.95 7.5 6v10.5q0 1.65 1.175 2.825Q9.85 20.5 11.5 20.5q1.65 0 2.825-1.175Q15.5 18.15 15.5 16.5V6H17v10.5q0 2.3-1.6 3.9T11.5 22Z"/>
                                </x-svg>
                                <p class="text-xs font-bold text-gray-500">Files</p>
                            </div>
                    
                            <div class="max-h-44 overflow-y-auto">
                                <template x-for="(name, index) in fileName" :key="index">
                                    <p x-text="name" class="text-sm mt-2 text-blue-600 cursor-pointer hover:underline"  @click="window.open(imgsrc[index])"> </p>
                                </template>
                            </div>
                        </div>

                    </div>

                

                    {{-- Row #7 Comments Table --}}
                    <input type="hidden" name="comments" x-ref="comments">
                    <div x-data="comment_suggestion_handler()" @load.window="onLoad()">
                        <hr class="mt-6 border-1 border-bland-300">

                            <div class="flex justify-between items-end mt-4">

                                <h1 class="text-lg text-bland-600 font-bold">Comments</h1>

                            </div>
                        
                            {{-- Custom table --}}
                            <div class="bg-white mt-4 h-auto w-full border-b border-gray-200 shadow-sm">
                                <div id="participant-container" class="overflow-auto block max-h-[420px] rounded-sm scroll-smooth">
                                    <table class="table-auto w-full border-collapse border text-left">
                            
                                        {{-- Table Head--}}
                                        <thead class="border-b bg-bland-200 sticky top-0 z-10">
                                            {{-- Insert Table Head Columns Here --}}
                                            <x-table.head-col class="md:pr-96">Message</x-table.head-col>
                                            <x-table.head-col class="text-center">Action</x-table.head-col>
                                            {{-- Table Head Columns Ends Here --}}
                                        </thead>
                                        {{-- Table Body --}}
                                        <tbody>
                                            <template x-for="(field, index) in comments[0]" :key="index">
                                                <tr class="bg-white  hover:bg-bland-100">
                                                    {{-- Insert Table Body Columns Here --}}
                                                    <x-table.body-col>
                                                        <x-input x-model="field.message"  id="comment" class="mt-1 w-full" type="text" name="comments[]"  readonly autofocus />
                                                    </x-table.body-col>
                                                    <x-table.body-col class="text-center">
                                                        <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="removeComment(index)">
                                                            {{ __('Remove') }}
                                                        </x-button>
                                                    </x-table.body-col>
                                                    {{-- Table Body Columns Ends Here --}}
                                                </tr>
                
                                            </template>
                                        </tbody>
                                        <tfoot class="border-t border-bland-200 bg-white sticky bottom-0">
                                        <tr>
                                        {{-- Insert Table Footer Columns Here --}}
                                        <x-table.footer-col>
                                            <x-input x-model="newComments[0].message" class="mt-1 w-full" type="text" autofocus />
                                        </x-table.footer-col>
                                        <x-table.footer-col class="px-1 text-center" @click="addComment">
                                            <x-button>
                                                {{ __('Add Row') }}
                                            </x-button>
                                        </x-table.footer-col>
                                        {{-- Table Footer Columns Ends Here --}}
                                    </tr>
                                        </tfoot>
                            
                                    </table>
                                </div>
                            </div>
                            <span x-show="err_comments" class="flex text-sm text-semantic-danger font-light">*<p x-text="msg_comments"></p></span>
                            @error('comments')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror


                        {{-- Row #8 Suggestions Table --}}

                            <div class="flex justify-between items-end mt-4">

                                <h1 class="text-lg text-bland-600 font-bold">Suggestions</h1>

                                <div>

                                </div>

                            </div>
                        
                            {{-- Custom table --}}
                            <input type="hidden" name="suggestions" x-ref="suggestions">
                            <div class="bg-white mt-4 h-auto w-full border-b border-gray-200 shadow-sm">
                                <div id="participant-container" class="overflow-auto block max-h-[420px] rounded-sm scroll-smooth">
                                    <table class="table-auto w-full border-collapse border text-left">
                            
                                        {{-- Table Head--}}
                                        <thead class="border-b bg-bland-200 sticky top-0 z-10">
                                            {{-- Insert Table Head Columns Here --}}
                                            <x-table.head-col class="md:pr-96">Message</x-table.head-col>
                                            <x-table.head-col class="text-center">Action</x-table.head-col>
                                            {{-- Table Head Columns Ends Here --}}
                                        </thead>
                                        {{-- Table Body --}}
                                        <tbody>
                                            <template x-for="(field, index) in suggestions[0]" :key="index">
                                                <tr class="bg-white  hover:bg-bland-100">
                                                    {{-- Insert Table Body Columns Here --}}
                                                    <x-table.body-col>
                                                        <x-input x-model="field.message"  id="comment" class="mt-1 w-full" type="text" name="suggestions[]"  readonly autofocus />
                                                    </x-table.body-col>
                                                    <x-table.body-col class="text-center">
                                                        <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="removeSuggestion(index)">
                                                            {{ __('Remove') }}
                                                        </x-button>
                                                    </x-table.body-col>
                                                    {{-- Table Body Columns Ends Here --}}
                                                </tr>
                
                                            </template>
                                        </tbody>
                                        <tfoot class="border-t border-bland-200 bg-white sticky bottom-0">
                                        <tr>
                                        {{-- Insert Table Footer Columns Here --}}
                                        <x-table.footer-col>
                                            <x-input x-model="newSuggestions[0].message" class="mt-1 w-full" type="text" autofocus />
                                        </x-table.footer-col>
                                        <x-table.footer-col class="px-1 text-center" @click="addSuggestion">
                                            <x-button>
                                                {{ __('Add Row') }}
                                            </x-button>
                                        </x-table.footer-col>
                                        {{-- Table Footer Columns Ends Here --}}
                                    </tr>
                                        </tfoot>
                            
                                    </table>
                                </div>
                            </div>
                            <span x-show="err_suggestions" class="flex text-sm text-semantic-danger font-light">*<p x-text="msg_suggestions"></p></span>
                            @error('suggestions')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                            <div class="flex justify-end items-center mt-4 space-x-2">

                                <p class="text-xs text-bland-400 font-light italic">*For Comments, Suggestions, and Rating</p>
                                <x-button>
                                    
                                    <x-svg>
                                        <path d="M6 20q-.825 0-1.412-.587Q4 18.825 4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413Q18.825 20 18 20Zm5-4V7.85l-2.6 2.6L7 9l5-5 5 5-1.4 1.45-2.6-2.6V16Z"/>
                                    </x-svg>
                                    {{ __('Upload CSV') }}

                                    <input 
                                        type="file" 
                                        name="comments_csv" 
                                        id="comments_csv" 
                                        accept=".csv"
                                        class="absolute cursor-pointer right-0 opacity-0"
                                        @change="readCSV, loading('true')"
                                    >

                                </x-button>
                            </div>


                        {{-- Row #9 --}}               
                        <div class="grid grid-flow-row auto-rows-max mt-4 md:grid-cols-4">

                            {{-- Rating --}}
                            <div>
                                <x-label for="ratings" :value="__('Rating')" />
                                
                                <x-input x-model="getTotalRating" id="ratings" class="mt-1 w-full" type="number" name="ratings" step=".1" required autofocus @keyup="storeInput($el)"/>
                                <span x-show="err_ratings" class="flex text-sm text-semantic-danger font-light">*<p x-text="msg_ratings"></p></span>
                                @error('ratings')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror

                            </div>

                        </div>
            
                    </div>

                    {{-- Submit Button--}}
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












