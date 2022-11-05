@php
    Helper::isAuthorized('Moderator|Editor', $forms->organization_id);
    $items = json_encode($reqItems);
@endphp
<x-app-layout>
    <div class="py-24"> 
        <div class="max-w-screen mx-auto px-4 lg:px-8">
            <div class="flex justify-between flex-wrap">
                <h1 class="flex items-center text-xl">
                    <span>
                        <x-svg width="w-7" height="w-7" color="fill-bland-600">
                            <path d="M11 18h2v-1h1q.425 0 .713-.288Q15 16.425 15 16v-3q0-.425-.287-.713Q14.425 12 14 12h-3v-1h4V9h-2V8h-2v1h-1q-.425 0-.712.287Q9 9.575 9 10v3q0 .425.288.712Q9.575 14 10 14h3v1H9v2h2Zm-5 4q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h8l6 6v12q0 .825-.587 1.413Q18.825 22 18 22Zm0-2h12V8.85L13.15 4H6v16Zm0 0V4v16Z"/>
                        </x-svg>
                    </span> 
                    Budget Requisition Form
                </h1>
            </div>
            <hr class="mt-3">

            <!-- Form Deinied - Message -->
            <x-edit-form-message message="{{$forms->remarks}}" approver="{{$forms->curr_approver}}"/>

            <div class="bg-white mt-4 h-auto w-full rounded-sm shadow-sm px-6 py-4">
                <form action="{{ route('forms.requisition.update', ['forms' => $forms->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Row #1 --}}                 
                    <div class="grid grid-flow-row auto-rows-max gap-6 md:grid-cols-2">

                        {{-- Event Title --}}
                        <div>
                            <x-label for="event_id" :value="__('Event Title')" />

                            <x-select class="mt-1" id="event_id" name="event_id" aria-label="Default select example" >
                                <option value='' selected disabled>--select option--</option>
                                @foreach($eventList as $event)
                                <option {{ $forms->event_id == $event->event_id ? 'selected' : '' }} value="{{$event->event_id}}">{{$event->event_title}}</option>
                                @endforeach
                            </x-select>
                            @error('event_id')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                        {{-- Date Filed --}}
                        <div>
                            <x-label for="date_filed" :value="__('Date Filed')" />
                            
                            <x-input id="date_filed" class="mt-1 w-full" type="date" name="date_filed" value="{{$requisition->date_filed}}" readonly autofocus />
                            @error('date_filed')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                    </div>

                    {{-- Row #2 --}}                 
                    <div class="grid grid-flow-row auto-rows-max gap-6 mt-4 md:grid-cols-2">

                        {{-- Date Needed --}}
                        <div>
                            <x-label for="date_needed" :value="__('Date Needed')" />

                            <x-input id="date_needed" class="mt-1 w-full" type="date" name="date_needed" value="{{$requisition->date_needed}}" required autofocus />
                            @error('date_needed')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                        {{-- Payment --}}
                        <div>
                            <x-label for="payment" :value="__('Payment')" />
                        
                            <x-select class="mt-1" id="payment" name="payment" aria-label="Default select example" >
                                <option value='' disabled>--select payment--</option>
                                <option {{ $requisition->payment == 'payment' ? 'selected' : '' }} value="payment">Payment</option>
                                <option {{ $requisition->payment == 'purchase' ? 'selected' : '' }} value="purchase">Purchase</option>
                            </x-select>
                            @error('payment')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                        </div>

                    </div>

                    {{-- Row #3 Requisition Items --}}
                    <hr class="mt-6 border-1 border-bland-300">

                    <h1 class="text-lg text-bland-600 font-bold my-4">Items</h1>

                    <input type="hidden" name="items" x-ref="items">
                    <div x-data="requisition_items_handler_edit()" @load.window="loadItems('{{ $items }}')">
                        <x-table.main>
                            {{-- Table Head--}}
                            <x-table.head>
                                {{-- Insert Table Head Columns Here --}}
                                <x-table.head-col class="w-32 pr-12 sm:pr-3">Item No.</x-table.head-col>
                                <x-table.head-col>Particulars/Purpose</x-table.head-col>
                                <x-table.head-col class="pr-12 sm:pr-3">Quantity</x-table.head-col>
                                <x-table.head-col class="pr-12 sm:pr-3">Price (₱)</x-table.head-col>
                                <x-table.head-col class="text-center">Action</x-table.head-col>
                                {{-- Table Head Columns Ends Here --}}
                            </x-table.head>
                            {{-- Table Body --}}
                            <tbody>
                                <template x-for="(field, index) in requisitions[0]" :key="index">
                                    <tr class="bg-white  hover:bg-bland-100">
                                        {{-- Insert Table Body Columns Here --}}
                                        <x-table.body-col>
                                            <x-input x-model="field.item_number"  id="item_number" class="mt-1 w-full" type="text" name="item_number[]"  readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col>
                                            <x-input x-model="field.purpose" id="purpose" class="mt-1 w-full" type="text" name="purpose[]"  readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col>
                                            <x-input x-model="field.quantity"  id="quantity" class="mt-1 w-full" type="number" min="1" name="quantity[]"  readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col>
                                            <x-input x-model="field.price" id="price" class="mt-1 w-full" type="number" min="1" name="price[]" readonly autofocus />
                                        </x-table.body-col>
                                        <x-table.body-col class="text-center px-1">
                                            <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="removeRequisition(index)">
                                                {{ __('Remove') }}
                                            </x-button>
                                        </x-table.body-col>
                                        {{-- Table Body Columns Ends Here --}}
                                    </tr>
                                </template>
                            </tbody>
                                {{-- Table Footer --}}
                            <tfoot class="border-t border-bland-100">
                                <tr>
                                    {{-- Insert Table Footer Columns Here --}}
                                    <x-table.footer-col>
                                        <x-input x-model="getItemNumber()" class="mt-1 w-full" type="text" readonly />
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newRequisitions[0].purpose" class="mt-1 w-full" type="text" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newRequisitions[0].quantity" class="mt-1 w-full" type="number" min="1" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        <x-input x-model="newRequisitions[0].price" class="mt-1 w-full" type="number" min="1" autofocus />
                                    </x-table.footer-col>
                                    <x-table.footer-col class="px-1 text-center">
                                        <x-button @click="addRequisition()">
                                            {{ __('Add Row') }}
                                        </x-button>
                                    </x-table.footer-col>
                                    {{-- Table Footer Columns Ends Here --}}
                                </tr>
                                <tr class="bg-bland-100">
                                    {{-- Insert Table Footer Columns Here --}}
                                    <x-table.footer-col>
                                        {{-- Empty Space --}}
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        {{-- Empty Space --}}
                                    </x-table.footer-col>
                                    <x-table.footer-col  class="text-right">
                                        <p class="font-bold">Total:</p>
                                    </x-table.footer-col>
                                    <x-table.footer-col class="pl-4">
                                        <span class="flex">₱ <p x-text="getTotal()"></p></span>
                                    </x-table.footer-col>
                                    <x-table.footer-col>
                                        {{-- Empty Space --}}
                                    </x-table.footer-col>
                                    {{-- Table Footer Columns Ends Here --}}
                                </tr>
                            </tfoot>
                        </x-table.main>
                        <span x-show="error" class="flex text-sm text-semantic-danger font-light">*<p x-text="msg"></p></span>
                        @error('items')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                    </div>

                    {{-- Row #4 --}}          
                    <div class="mt-2">
                        <x-label for="remarks" :value="__('Remarks')" />

                        <x-text-area id="remarks" name="remarks">{{$requisition->remarks}}</x-text-area>
                        @error('remarks')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
                    </div>

                    {{-- Row #5 --}}
                    <div class="grid mt-4 md:grid-cols-3">
                        <x-label for="department_id" :value="__('Charge To')" />

                        <x-select class="mt-1" id="department_id" name="department_id" aria-label="Default select example" >
                            <option value='' selected disabled>--select option--</option>
                            @foreach($departments as $department)
                            <option {{ $requisition->department_id == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </x-select>
                        @error('department_id')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror
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
</x-app-layout>












