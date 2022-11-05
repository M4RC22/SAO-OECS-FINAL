<x-app-layout>
  
    <!-- Error Mesage -->
    <x-alert-message/>

    <!-- table -->
    <div class="py-24">    
        <div class="max-w-screen mx-auto px-4 lg:px-8">
            <h1 class="text-xl">Department Heads</h1>
            <x-table.main>
                {{-- Table Head--}}
                <x-table.head>
                    {{-- Insert Table Head Columns Here --}}
                    <x-table.head-col class="pl-6 font-bold">Name</x-table.head-col>
                    <x-table.head-col class="pl-6 font-bold">Department</x-table.head-col>
                    <x-table.head-col class="pl-6 font-bold">Position</x-table.head-col>
                    <x-table.head-col class="pl-6 font-bold">Action</x-table.head-col>

            
                {{-- Table Head Columns Ends Here --}}
                </x-table.head>
                {{-- Table Head Body --}}
               @foreach ($departmentHeads as $head)
               <x-table.body>
                    {{-- Insert Table Body Columns Here --}}
                    <x-table.body-col class="pl-6">{{ $head['name'] }}</x-table.body-col>
                    <x-table.body-col class="pl-6">{{ $head['department'] }}</x-table.body-col>
                    <x-table.body-col class="pl-6">{{ $head['position'] }}</x-table.body-col>
                    <x-table.body-col class="pl-6">
                        @php
                            $userId = $head['user_id'];
                            $departmentId = $head['department_id'];
                        @endphp
                        <button onclick="window.location='{{ route('department-heads.edit', ['departmentId' => $departmentId, 'userId' => $userId ]) }}'">
                            <x-svg color="fill-primary-blue" marginRight="mr-0" class="cursor-pointer hover:fill-semantic-info">
                                <path d="M5 23.7q-.825 0-1.413-.588Q3 22.525 3 21.7v-14q0-.825.587-1.413Q4.175 5.7 5 5.7h8.925l-2 2H5v14h14v-6.95l2-2v8.95q0 .825-.587 1.412-.588.588-1.413.588Zm7-9Zm4.175-8.425 1.425 1.4-6.6 6.6V15.7h1.4l6.625-6.625 1.425 1.4-7.2 7.225H9v-4.25Zm4.275 4.2-4.275-4.2 2.5-2.5q.6-.6 1.438-.6.837 0 1.412.6l1.4 1.425q.575.575.575 1.4T22.925 8Z"/>
                            </x-svg>
                        </button>
                    </x-table.body-col>
                    {{-- Table Body Columns Ends Here --}}
                </x-table.body>
               @endforeach             
            </x-table.main>
            
            <!-- Pagination --->
            <div class="mt-4">
               
            </div>
        </div>
    </div>
   
</x-app-layout>
