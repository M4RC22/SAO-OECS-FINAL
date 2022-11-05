<!-- Error Mesage -->
<x-alert-message/>
@if ($errors->any())
<div x-data="{form: true }" >
@else
<div x-data="{form: false }" >
@endif
    <div class="mt-14 h-auto w-full rounded-sm px-6 py-4">
        <div class="flex flex-col justify-center items-center py-16 px-2 md:px-8">
            <img class="w-auto h-auto sm:h-96 object-cover" src="{{ asset('assets/img/group.png')}}" alt="No Organization"/>
            @if(Helper::hasPendingApplication())
            <div class="text-center space-y-3 mt-6">
                <h1 class="text-2xl text-bland-500 font-bold tracking-wide">Your Application Was Sent. </h1>
                <p class="text-sm text-bland-400">Please wait for the approval of the SAO Head. We will notify you shortly! </p>
            </div>
            @else
            <div class="text-center space-y-3 mt-6">
                <h1 class="text-2xl text-bland-500 font-bold tracking-wide">Do You Want To Create An Organization? </h1>
                <p class="text-sm text-bland-400">To create an organization please click the button below. </p>
                <div>
                    <a href="#org-application">
                        <x-button @click="form = true">
                            {{ __('Create Organization')}}
                        </x-button>
                    </a>  
                </div>
            </div>
            @endif
        </div>
    </div>
    

    <div x-show="form" x-transition id="org-application">
        <div class="bg-white">
            <div class="px-12 md:px-32 py-6">
                <div class="absolute right-9 cursor-pointer" @click="form = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-bland-400 hover:fill-bland-600" fill="currentColor" height="24" width="24">
                        <path d="M6.4 19 5 17.6l5.6-5.6L5 6.4 6.4 5l5.6 5.6L17.6 5 19 6.4 13.4 12l5.6 5.6-1.4 1.4-5.6-5.6Z"/>
                    </svg>
                </div>
                <h1 class="text-xl text-bland-500 text-center tracking-wide my-8">Application for Organization Creation</h1>
                <form action="{{ route('org-application.create')}}" method="POST">
                    @csrf
                    {{-- Org Name --}}
                    <div>
                        <x-label for="org_name" :value="__('Organization Name')" />
                        
                        <x-input id="org_name" class="mt-1 w-full" type="text" name="org_name" :value="old('org_name')" required />
                        @error('org_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mt-2">
                        <x-label for="description" :value="__('Description')" />
                        
                        <x-text-area id="description" class="mt-1 w-full" type="text" name="description" required>{{ Request::old('description') }}</x-text-area>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Purpose --}}
                    <div class="mt-2">
                        <x-label for="purpose" :value="__('Purpose')" />
                        
                        <x-text-area id="purpose" class="mt-1 w-full" type="text" name="purpose" required>{{ Request::old('purpose') }}</x-text-area>
                        @error('purpose')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <p class="text-xs text-bland-400 italic mt-2">Note: Once you submit this application it will be reviewed first by the SAO Head. We will notify you shortly once we get the SAO Head's decision.</p>

                    <div class="flex justify-end mt-4">
                        <x-button type="submit">
                            {{ __('Submit')}}
                        </x-button>
                    </div>
                    
                </form>
            </div>  
        </div>
    </div>

</div>