@php
    $isModerator = Auth::user()->checkOrgRole('Moderator', $currOrg->id)
@endphp
<x-app-layout>
    <!-- Org Name -->
    <div class="pt-24">
        <div class="max-w-screen mx-auto px-4 lg:px-8">
            <h1 class="text-xl"><span class="text-primary-blue hover:text-semantic-info"> <a href="{{ route('organization.index') }}"> Organizations </a></span>/ {{ $currOrg->org_name }}</h1>
            {{-- <div class="bg-white mt-4 h-auto w-full rounded-sm shadow-sm">
                <h1 class="text-md px-6 py-4">{{$currOrg->orgName}}</h1>
            </div> --}}
        </div>
    </div>

    <!-- Alert Message For adding, editing, and deleting org member -->
    <x-alert-message/>   

    <!-- table -->
    <div class="mt-8 pb-24">
        <div class="max-w-screen mx-auto px-4 lg:px-8">
            <div class="flex justify-between">
                <h1 class="text-lg">Members ({{ $totalMembers }})</h1>
                @if($isModerator)
                <div>
                    {{-- Add Member Modal Button --}}
                    <x-button onclick="window.location='{{ route('organization.add', ['id' => $currOrg->id]) }}'">
                        {{ __('Add Member') }}
                    </x-button>
                </div>
                @endif
            </div>

            <x-table.main>
                {{-- Table Head--}}
                <x-table.head>
                    {{-- Insert Table Head Columns Here --}}
                    <x-table.head-col class="pl-6 font-bold">Name</x-table.head-col>
                    <x-table.head-col class="pl-6 font-bold">Position</x-table.head-col>
                    <x-table.head-col class="pl-6 font-bold">Role</x-table.head-col>
                    @if($isModerator)
                    <x-table.head-col class="text-center font-bold">Action</x-table.head-col>
                    @endif
                    {{-- Table Head Columns Ends Here --}}
                </x-table.head>
                {{-- Table Head Body --}}
                @foreach ($orgMembers as $member)
                <x-table.body>
                    {{-- Insert Table Body Columns Here --}}
                    <x-table.body-col class="pl-6">{{ $member->first_name }} {{ $member->last_name }}</x-table.body-col>
                    <x-table.body-col class="pl-6">{{ $member->pivot->position }} </x-table.body-col>
                    <x-table.body-col class="pl-6">{{ $member->pivot->role }}</x-table.body-col>
                    @if($isModerator)
                    <x-table.body-col class="flex justify-center space-x-5">
                        <button onclick="window.location='{{ route('organization.select', ['id' => $currOrg->id, 'member' => $member]) }}'">
                            <x-svg color="fill-primary-blue" marginRight="mr-0" class="cursor-pointer hover:fill-semantic-info">
                                <path d="M5 23.7q-.825 0-1.413-.588Q3 22.525 3 21.7v-14q0-.825.587-1.413Q4.175 5.7 5 5.7h8.925l-2 2H5v14h14v-6.95l2-2v8.95q0 .825-.587 1.412-.588.588-1.413.588Zm7-9Zm4.175-8.425 1.425 1.4-6.6 6.6V15.7h1.4l6.625-6.625 1.425 1.4-7.2 7.225H9v-4.25Zm4.275 4.2-4.275-4.2 2.5-2.5q.6-.6 1.438-.6.837 0 1.412.6l1.4 1.425q.575.575.575 1.4T22.925 8Z"/>
                            </x-svg>
                        </button>
                    </x-table.body-col>
                    @endif
                    {{-- Table Body Columns Ends Here --}}
                </x-table.body>
                @endforeach
            </x-table.main>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $orgMembers->links('pagination::tailwind')}}
            </div>
            
        </div>
    </div>
</x-app-layout>

            