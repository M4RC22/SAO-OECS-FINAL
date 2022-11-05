<x-app-layout>   
    
    <!-- Error Mesage -->
    <x-alert-message/>

    <div x-data="{ replace:false, modal:false }" class="py-24">
        <div class="px-4 lg:px-8">
            <h1 class="text-xl"><span class="text-primary-blue hover:text-semantic-info"> <a href="{{ route('department-heads.index') }}"> Department Heads </a></span>/ Replace Department Head
            <div class="flex flex-col">
                <div class="flex">
                    <div class="basis-full h-auto bg-white mt-4 rounded-sm shadow-sm p-6 lg:basis-[50%] xl:basis-[40%]">
                        <p class="text-sm text-bland-400">Current Department Head</p>
                        <div class="space-y-6">
                            <div>
                                <!-- Name -->
                                <x-label for="name" :value="__('Name')" />

                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $headInfo->first_name }} {{ $headInfo->last_name }}" disabled="true" autofocus />
                            </div>

                            <!-- Department -->
                            <div class="mt-3">
                                <x-label for="position" :value="__('Department')" />
                            
                                <x-input id="department" class="block mt-1 w-full" type="text" name="department" disabled="true" autofocus value="{{ $departmentInfo->name }}" />
                            </div>

                            <!-- Position -->
                            <div class="mt-3">
                                <x-label for="position" :value="__('Position')" />
                            
                                <x-input id="position" class="block mt-1 w-full" type="text" name="position"  disabled="true" autofocus value="Head" />
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="flex">
                    <div class="basis-full h-auto bg-white mt-4 rounded-sm shadow-sm p-6 lg:basis-[50%] xl:basis-[40%]"> 
                        <p class="text-sm text-bland-400">New Department Head</p>
                        <form action="{{ route('department-heads.update', ['departmentId' => $departmentInfo->id, 'userId' => $headInfo->id ])}}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Email -->
                            <div>
                                <x-label for="email" :value="__('Email')" />
                            
                                <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus value="" />
                                @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <p class="text-xs text-bland-500 italic mt-2">Note: To replace current head please enter the email of new deparment head.</p>


                            <!-- Replace Head Button -->
                            <div class="flex justify-end pt-6">
                                <div class="">
                                    <x-button bg="bg-semantic-success" hover="hover:bg-green-600" type="button" @click="replace = true, modal = true">
                                        {{ __('Assign') }}
                                    </x-button>
                                </div>
                            </div>


                            <!-- Replace Department Head Modal -->
                            <x-modal name="replace">
                                <div class="text-sm py-5 text-left">
                                    Once you click confirm <b>{{ $headInfo->first_name }} {{ $headInfo->last_name }}</b> will be replaced by new department head.
                                </div>
                                
                                <div class="flex justify-end space-x-2 mt-5">
                                    <x-button bg="bg-semantic-success" hover="hover:bg-green-600" type="submit"  @click="replace = false, modal = false">
                                        {{ __('Confirm') }}
                                    </x-button>
                                    <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="replace = false, modal = false" >
                                            {{ __('Cancel') }}
                                    </x-button>
                                </div>
                            </x-modal>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
        
</x-app-layout>

            