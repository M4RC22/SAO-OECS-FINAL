@props(['message', 'approver' => ''])

<div x-data="{ scrollAtTop : true}">

    <div @scroll.window=" scrollAtTop = (window.pageYOffset > 50) ?  false : true">

        {{-- Show when scroll is at top --}}
        <div 
            x-cloak
            x-show="scrollAtTop"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-6"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 translate-x-12" 
            class="w-full bg-yellow-100 rounded-sm my-2 border-2 border-primary-yellow">
            <div class="p-4 text-yellow-700">
                <div class="flex mb-2">
                    <x-svg class="mr-0" color="fill-yellow-700">
                        <path d="M1 21 12 2l11 19Zm3.45-2h15.1L12 6ZM12 18q.425 0 .713-.288Q13 17.425 13 17t-.287-.712Q12.425 16 12 16t-.712.288Q11 16.575 11 17t.288.712Q11.575 18 12 18Zm-1-3h2v-5h-2Zm1-2.5Z"/>
                    </x-svg>
                    <h1 class="text-xl tracking-wide"><strong>The Form was Denied!</strong></h1>
                </div>
                <p class="text-sm mb-2"><b>Approver: </b>{{ $approver }}</p>
                <hr class="border-yellow-700 opacity-30">
                <p class="text-sm mt-2"><b>Message: </b>{{ $message }}</p>
            </div>
        </div>
    
        {{-- Show when scroll is not at top --}}
        <div 
            x-cloak
            x-show="!scrollAtTop"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            
            <div x-data="{ messageOnHover: false }">
                <div 
                    x-cloak
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-1000"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-show="!messageOnHover"
                    class="fixed bg-yellow-100 bottom-12 right-3 z-30 rounded-lg border border-primary-yellow" @mouseover="messageOnHover = true">
                    <div class="p-2">
                        <x-svg class="mr-0" width="w-8" height="h-8" color="fill-yellow-700" marginRight="mr-0">
                            <path d="M6 14h12v-2H6Zm0-3h12V9H6Zm0-3h12V6H6Zm16 14-4-4H4q-.825 0-1.412-.587Q2 16.825 2 16V4q0-.825.588-1.413Q3.175 2 4 2h16q.825 0 1.413.587Q22 3.175 22 4ZM4 4v12h14.825L20 17.175V4H4Zm0 0v13.175V4Z"/>
                        </x-svg>
                    </div>
                </div>
        
                <div 
                    x-cloak
                    x-show="messageOnHover" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-80 translate-x-6 translate-y-6"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 translate-x-6 translate-y-6 "
                    class="max-w-xl bg-yellow-100 fixed z-30 bottom-12 right-3 rounded-lg border border-primary-yellow" @mouseover.away="messageOnHover = false">
                    <div class="p-4 text-yellow-700">
                        <div class="flex mb-2">
                            <x-svg class="mr-0" color="fill-yellow-700">
                                <path d="M1 21 12 2l11 19Zm3.45-2h15.1L12 6ZM12 18q.425 0 .713-.288Q13 17.425 13 17t-.287-.712Q12.425 16 12 16t-.712.288Q11 16.575 11 17t.288.712Q11.575 18 12 18Zm-1-3h2v-5h-2Zm1-2.5Z"/>
                            </x-svg>
                            <h1 class="text-xl tracking-wide"><strong>The Form was Denied!</strong></h1>
                        </div>
                        <p class="text-sm mb-2"><b>Approver: </b>{{ $approver }}</p>
                        <hr class="border-yellow-700 opacity-30">
                        <p class="text-sm mt-2"><b>Message: </b>{{ $message }}</p>
                    </div>
                </div>
        
            </div>
        </div>

    </div>
</div>

