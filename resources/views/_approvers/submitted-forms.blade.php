@php
    // $hasSubmittedForms = $pendingForms->isNotEmpty();
    $hasSubmittedForms = isset($pendingForms);
    $jsonForms = json_encode($pendingForms);
    $encryptedForms = base64_encode($jsonForms);
@endphp
<x-app-layout>
    <x-alert-message/>   
    {{-- If there's no record--}}
    @if(!$hasSubmittedForms) 
    <div class="mt-14 h-auto w-full rounded-sm px-6 py-4">
        <div class="flex flex-col justify-center items-center py-16 px-2 md:px-8">
            <img class="w-auto h-auto sm:h-96 object-cover" src="{{ asset('assets/img/no-submitted-form.png')}}" alt="No Organization"/>
            <div class="text-center space-y-3 mt-6">
                <h1 class="text-2xl text-bland-500 font-bold tracking-wide">You're All Clear! 🎉 </h1>
                <p class="text-sm text-bland-400">You don't have any pending form to review.</p>
            </div>
        </div>
    </div>
    @else
    {{-- If there's a record --}}
    <!-- Actions -->
    <div x-data="search()" @load.window="addForms('{{ $encryptedForms }}')" class="pt-24">
        <div class="px-4 lg:px-8">
            <div class="flex items-center justify-end space-x-1">
                <x-select class="w-48" id="form_type" name="form_type" aria-label="Default select example" x-ref="filter" @change="filter($el)">
                    <option value="" selected>All</option>
                    <option value="APF">Activity Proposal Form</option>
                    <option value="BRF">Requisition Form</option>
                    <option value="NR">Narrative Report</option>
                    <option value="LF">Liquidation Form</option>
                </x-select>
                <x-input class="w-48 md:w-64" type="search" id="search" name="search" placeholder="Search" x-ref="searchTerm" @keyup="searchTerm($el)"/>
                <x-button type="submit">
                    <x-svg marginRight="mr-0">
                        <path d="m19.6 21-6.3-6.3q-.75.6-1.725.95Q10.6 16 9.5 16q-2.725 0-4.612-1.887Q3 12.225 3 9.5q0-2.725 1.888-4.613Q6.775 3 9.5 3t4.613 1.887Q16 6.775 16 9.5q0 1.1-.35 2.075-.35.975-.95 1.725l6.3 6.3ZM9.5 14q1.875 0 3.188-1.312Q14 11.375 14 9.5q0-1.875-1.312-3.188Q11.375 5 9.5 5 7.625 5 6.312 6.312 5 7.625 5 9.5q0 1.875 1.312 3.188Q7.625 14 9.5 14Z"/>
                    </x-svg>
                </x-button>
            </div>
        </div>

        <!-- table -->
        <div class="mt-4">
            <div class="max-w-screen mx-auto px-4 lg:px-8">

                <x-table.main>
                    {{-- Table Head--}}
                    <x-table.head>
                        {{-- Insert Table Head Columns Here --}}
                        <x-table.head-col class="pl-6 font-bold">Event Title</x-table.head-col>
                        <x-table.head-col class="pl-6 font-bold">Organization</x-table.head-col>
                        <x-table.head-col class="pl-6 font-bold">Form Type</x-table.head-col>
                        <x-table.head-col class="pl-6 font-bold">Date Submitted</x-table.head-col>
                        <x-table.head-col class="pl-6 font-bold">Action</x-table.head-col>        
                    {{-- Table Head Columns Ends Here --}}
                    </x-table.head>
                   
                    {{-- Table Body --}}
                    <template x-for="item in formList()">
                        <x-table.body>
                            <x-table.body-col x-text="item.eventTitle" class="pl-6"></x-table.body-col>
                            <x-table.body-col x-text="item.organization" class="pl-6"></x-table.body-col>
                            <x-table.body-col x-text="item.formType" class="pl-6"></x-table.body-col>
                            <x-table.body-col class="pl-6">Later</x-table.body-col>
                            <x-table.body-col class="pl-6">
                                <a class="text-primary-blue cursor-pointer hover:text-blue-800 hover:underline hover:underline-offset-4" @click="viewForm(item.id)">View Details</a>
                        </x-table.body-col>
                    </template>
                    {{-- Table Body Columns Ends Here --}}
                    </x-table.body>
                </x-table.main>

                {{-- If search has no result --}}
                <template x-if="isResultsEmpty()">
                    <div class="flex flex-col justify-center items-center mt-12 px-2 md:px-8">
                        <img class="w-72 h-auto object-fill" src="{{ asset('assets/img/no-result.png')}}" alt="No Organization"/>
                        <div class="text-center space-y-3 mt-6">
                            <h1 class="text-2xl text-bland-500 font-bold tracking-wide">No Forms Found! 📣 </h1>
                            <p class="text-sm text-bland-400">We can't find what you're looking for.</p>
                        </div>
                    </div>
                </template>

                <div class="mt-4">
                    {{-- {{ $pendingForms->links('pagination::tailwind')}} --}}
                    <div x-show="pageCount() > 1" class="flex justify-center">
                        <ul class="flex list-style-none">
                        <li class="page-item"><a
                            class="page-link relative block py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 focus:shadow-none"
                            href="#">Previous</a>
                        </li>
                        <template x-for="(page,index) in pages()" :key="index">
                            <li>
                                <button
                                class="relative block py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                                :class="{ 'bg-indigo-600 text-white font-bold' : index === pageNumber }"
                                type="button"
                                x-on:click="viewPage(index)">

                                <span x-text="index+1"></span>
                                </button>
                            </li>
                        </template>
                        <li class="page-item"><a
                            class="page-link relative block py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                            href="#">Next</a>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
</x-app-layout>


