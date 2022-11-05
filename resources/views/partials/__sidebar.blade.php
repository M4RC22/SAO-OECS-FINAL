@php
    $isApprover = Helper::isApprover();
    $isOrgMember = auth()->user()->isOrgMember();    
@endphp
<!-- Sidebar Menu -->
<div :class="{ '!translate-x-0': open }" class="fixed top-0 left-0 z-40 w-64 h-screen overflow-y-auto transition duration-300 ease-in-out transform -translate-x-full bg-secondary-gray shadow-lg sm:w-64 lg:translate-x-0">
    <!-- Sidebar Header -->
    <div class="flex items-center p-4 mb-3 h-20">
        <div class="inline-flex items-center justify-center w-full md:justify-center">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center w-full">
                <img src="{{ asset('assets/img/apc-name-logo.png') }}" alt="" class="object-cover h-16">
            </a>
        </div>
    </div>

    <!-- Navigation Links -->
    <hr class=" h-px opacity-60">
    <div class="flex flex-col mt-3 mb-0 ml-0">
        <div x-cloak x-data="{ dropdown: $persist(false).using(sessionStorage) }">

            {{-- Dashboard --}}
            <x-sidebar-nav-link :href="route('dashboard')" :active="Helper::checkRoute('dashboard') || ((Helper::checkRoute('submitted-forms.show') || (Helper::checkRoute('forms.edit.show') )) && Auth::user()->checkUserType('Student'))" @click="dropdown = false">
                <x-slot name="icon">
                    <x-svg>
                        <path d="M4 21V9l8-6 8 6v12h-6v-7h-4v7Zm2-2h2v-7h8v7h2v-9l-6-4.5L6 10Zm6-6.75Z"/>
                    </x-svg>
                </x-slot>
                {{ __('Dashboard') }}
            </x-sidebar-nav-link>
            @if(Auth::user()->checkUserType('Student'))
            <!-- Dropdown Forms-->
            <x-sidebar-nav-link-dropdown  x-on:click="dropdown = !dropdown">
                <x-slot name="icon">
                    <x-svg>
                        <path d="M8 18h8v-2H8Zm0-4h8v-2H8Zm-2 8q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h8l6 6v12q0 .825-.587 1.413Q18.825 22 18 22Zm7-13V4H6v16h12V9ZM6 4v5-5 16V4Z"/>
                    </x-svg>
                </x-slot>
                {{ __('Forms') }}
                <x-slot name="arrow">
                    <div :class="{'rotate-180': dropdown}" >   
                        <x-svg class="mr-0">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
                        </x-svg>
                    </div>
                </x-slot>
            </x-sidebar-nav-link-dropdown>

            <!-- Dropdwon Links -->
            <div x-cloak x-show="dropdown" x-transition>

                {{-- Activity Proposal Form --}}
                <x-sidebar-nav-link class="pl-8" :href="route('forms.activity-proposal.index')" :active="request()->routeIs('forms.activity-proposal.index')">
                    <x-slot name="icon">
                        <x-svg>
                            <path d="M6 22q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h8l6 6v4h-2V9h-5V4H6v16h6v2Zm0-2V4v16Zm12.3-5.475 1.075 1.075-3.875 3.85v1.05h1.05l3.875-3.85 1.05 1.05-4.3 4.3H14v-3.175Zm3.175 3.175L18.3 14.525l1.45-1.45q.275-.275.7-.275.425 0 .7.275l1.775 1.775q.275.275.275.7 0 .425-.275.7Z"/>
                        </x-svg>
                    </x-slot>
                    {{ __('Activity Proposal Form') }}
                </x-sidebar-nav-link>

                {{-- Budget Requisition Form --}}
                <x-sidebar-nav-link class="pl-8" :href="route('forms.requisition.index')" :active="request()->routeIs('forms.requisition.index')">
                    <x-slot name="icon">
                        <x-svg>
                            <path d="M11 18h2v-1h1q.425 0 .713-.288Q15 16.425 15 16v-3q0-.425-.287-.713Q14.425 12 14 12h-3v-1h4V9h-2V8h-2v1h-1q-.425 0-.712.287Q9 9.575 9 10v3q0 .425.288.712Q9.575 14 10 14h3v1H9v2h2Zm-5 4q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h8l6 6v12q0 .825-.587 1.413Q18.825 22 18 22Zm0-2h12V8.85L13.15 4H6v16Zm0 0V4v16Z"/>
                        </x-svg>
                    </x-slot>
                    {{ __('Budget Requisition Form') }}
                </x-sidebar-nav-link>

                {{-- Narrative Report --}}
                <x-sidebar-nav-link class="pl-8" :href="route('forms.narrative.index')" :active="request()->routeIs('forms.narrative.index')">
                    <x-slot name="icon">
                        <x-svg>
                            <path d="M8 20q-.825 0-1.412-.587Q6 18.825 6 18v-3h3v-2.25q-.875-.05-1.662-.388-.788-.337-1.438-1.012v-1.1H4.75L1.5 7q.9-1.15 2.225-1.625Q5.05 4.9 6.4 4.9q.675 0 1.313.1.637.1 1.287.375V4h12v13q0 1.25-.875 2.125T18 20Zm3-5h6v2q0 .425.288.712.287.288.712.288t.712-.288Q19 17.425 19 17V6h-8v.6l6 6V14h-1.4l-2.85-2.85-.2.2q-.35.35-.738.625-.387.275-.812.425ZM5.6 8.25h2.3v2.15q.3.2.625.275.325.075.675.075.575 0 1.038-.175.462-.175.912-.625l.2-.2-1.4-1.4q-.725-.725-1.625-1.088Q7.425 6.9 6.4 6.9q-.5 0-.95.075-.45.075-.9.225ZM8 18h7.15q-.075-.225-.112-.475Q15 17.275 15 17H8Zm0 0v-1 1Z"/>
                        </x-svg>
                    </x-slot>
                    {{ __('Narrative Report') }}
                </x-sidebar-nav-link>

                {{-- Liquidation Form --}}
                <x-sidebar-nav-link class="pl-8" :href="route('forms.liquidation.index')" :active="request()->routeIs('forms.liquidation.index')">
                    <x-slot name="icon">
                        <x-svg>
                            <path d="M6 22q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h9l5 5v13q0 .825-.587 1.413Q18.825 22 18 22Zm0-2h12V8h-4V4H6v16Zm6-1q1.675 0 2.838-1.175Q16 16.65 16 15v-4h-2v4q0 .825-.575 1.413Q12.85 17 12 17q-.825 0-1.412-.587Q10 15.825 10 15V9.5q0-.225.15-.363Q10.3 9 10.5 9q.225 0 .363.137.137.138.137.363V15h2V9.5q0-1.05-.725-1.775Q11.55 7 10.5 7q-1.05 0-1.775.725Q8 8.45 8 9.5V15q0 1.65 1.175 2.825Q10.35 19 12 19ZM6 4v4-4 16V4Z"/>
                        </x-svg>
                    </x-slot>
                    {{ __('Liquidation Form') }}
                </x-sidebar-nav-link>

            </div>
            @endif

            @if(auth()->user()->isOrgMember() || Helper::isApprover())
            {{-- Roles --}}
            <x-sidebar-nav-link :href="route('organization.index')" active="{{ Helper::checkRoute('organization') }}" @click="dropdown = false">
                <x-slot name="icon">
                    <x-svg>
                        <path d="M1 20v-2.8q0-.85.438-1.563.437-.712 1.162-1.087 1.55-.775 3.15-1.163Q7.35 13 9 13t3.25.387q1.6.388 3.15 1.163.725.375 1.162 1.087Q17 16.35 17 17.2V20Zm18 0v-3q0-1.1-.612-2.113-.613-1.012-1.738-1.737 1.275.15 2.4.512 1.125.363 2.1.888.9.5 1.375 1.112Q23 16.275 23 17v3ZM9 12q-1.65 0-2.825-1.175Q5 9.65 5 8q0-1.65 1.175-2.825Q7.35 4 9 4q1.65 0 2.825 1.175Q13 6.35 13 8q0 1.65-1.175 2.825Q10.65 12 9 12Zm10-4q0 1.65-1.175 2.825Q16.65 12 15 12q-.275 0-.7-.062-.425-.063-.7-.138.675-.8 1.037-1.775Q15 9.05 15 8q0-1.05-.363-2.025Q14.275 5 13.6 4.2q.35-.125.7-.163Q14.65 4 15 4q1.65 0 2.825 1.175Q19 6.35 19 8ZM3 18h12v-.8q0-.275-.137-.5-.138-.225-.363-.35-1.35-.675-2.725-1.013Q10.4 15 9 15t-2.775.337Q4.85 15.675 3.5 16.35q-.225.125-.362.35-.138.225-.138.5Zm6-8q.825 0 1.413-.588Q11 8.825 11 8t-.587-1.412Q9.825 6 9 6q-.825 0-1.412.588Q7 7.175 7 8t.588 1.412Q8.175 10 9 10Zm0 8ZM9 8Z"/>
                    </x-svg>
                </x-slot>
                {{ __('Organizations') }}
            </x-sidebar-nav-link>
            @endif

            @if(Auth::user()->checkUserType('Professor|Staff') && ($isApprover || $isOrgMember)) 
            {{-- Submitted Forms --}}
            <x-sidebar-nav-link :href="route('submitted-forms.index')" active="{{ Helper::checkRoute('submitted-forms') }}" @click="dropdown = false">
                <x-slot name="icon">
                    <x-svg>
                        <path d="M11 19h2v-4.175l1.6 1.6L16 15l-4-4-4 4 1.425 1.4L11 14.825Zm-5 3q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h8l6 6v12q0 .825-.587 1.413Q18.825 22 18 22Zm7-13V4H6v16h12V9ZM6 4v5-5 16V4Z"/>
                    </x-svg>
                </x-slot>
                {{ __('Submitted Forms') }}
            </x-sidebar-nav-link>
            @endif

            @if(Auth::user()->checkUserType('Student|Professor|Staff') && ($isApprover || $isOrgMember))
            {{-- Records --}}
            <x-sidebar-nav-link :href="route('records')" :active="request()->routeIs('records')" @click="dropdown = false">
                <x-slot name="icon">
                    <x-svg>
                        <path d="M12 11q-3.75 0-6.375-1.175T3 7q0-1.65 2.625-2.825Q8.25 3 12 3t6.375 1.175Q21 5.35 21 7q0 1.65-2.625 2.825Q15.75 11 12 11Zm0 5q-3.75 0-6.375-1.175T3 12V9.5q0 1.1 1.025 1.863 1.025.762 2.45 1.237 1.425.475 2.963.687 1.537.213 2.562.213t2.562-.213q1.538-.212 2.963-.687 1.425-.475 2.45-1.237Q21 10.6 21 9.5V12q0 1.65-2.625 2.825Q15.75 16 12 16Zm0 5q-3.75 0-6.375-1.175T3 17v-2.5q0 1.1 1.025 1.863 1.025.762 2.45 1.237 1.425.475 2.963.688 1.537.212 2.562.212t2.562-.212q1.538-.213 2.963-.688t2.45-1.237Q21 15.6 21 14.5V17q0 1.65-2.625 2.825Q15.75 21 12 21Z"/>
                    </x-svg>
                </x-slot>
                {{ __('Records') }}
            </x-sidebar-nav-link>
            @endif

            @if(Helper::isSaoHead() ) 
            {{-- Aprrovers --}}
            <x-sidebar-nav-link :href="route('department-heads.index')" active="{{ Helper::checkRoute('department-heads') }}" @click="dropdown = false">
                <x-slot name="icon">
                    <x-svg>
                        <path d="M4 22q-.825 0-1.412-.587Q2 20.825 2 20V9q0-.825.588-1.413Q3.175 7 4 7h5V4q0-.825.588-1.413Q10.175 2 11 2h2q.825 0 1.413.587Q15 3.175 15 4v3h5q.825 0 1.413.587Q22 8.175 22 9v11q0 .825-.587 1.413Q20.825 22 20 22Zm0-2h16V9h-5q0 .825-.587 1.412Q13.825 11 13 11h-2q-.825 0-1.412-.588Q9 9.825 9 9H4v11Zm2-2h6v-.45q0-.425-.238-.788-.237-.362-.662-.562-.5-.225-1.012-.337Q9.575 15.75 9 15.75q-.575 0-1.087.113-.513.112-1.013.337-.425.2-.662.562Q6 17.125 6 17.55Zm8-1.5h4V15h-4ZM9 15q.625 0 1.062-.438.438-.437.438-1.062t-.438-1.062Q9.625 12 9 12t-1.062.438Q7.5 12.875 7.5 13.5t.438 1.062Q8.375 15 9 15Zm5-1.5h4V12h-4ZM11 9h2V4h-2Zm1 5.5Z"/>
                    </x-svg>
                </x-slot>
                {{ __('Department Heads') }}
            </x-sidebar-nav-link>

            {{-- Applications --}}
            <x-sidebar-nav-link :href="route('org-application.index')" active="{{ Helper::checkRoute('org-application') }}" @click="dropdown = false">
                <x-slot name="icon">
                    <x-svg>
                        <path d="M12.5 11.95q.725-.8 1.113-1.825Q14 9.1 14 8t-.387-2.125Q13.225 4.85 12.5 4.05q1.5.2 2.5 1.325T16 8q0 1.5-1 2.625t-2.5 1.325ZM18 20v-3q0-.9-.4-1.712-.4-.813-1.05-1.438 1.275.45 2.363 1.162Q20 15.725 20 17v3Zm2-7v-2h-2V9h2V7h2v2h2v2h-2v2ZM8 12q-1.65 0-2.825-1.175Q4 9.65 4 8q0-1.65 1.175-2.825Q6.35 4 8 4q1.65 0 2.825 1.175Q12 6.35 12 8q0 1.65-1.175 2.825Q9.65 12 8 12Zm-8 8v-2.8q0-.85.438-1.563.437-.712 1.162-1.087 1.55-.775 3.15-1.163Q6.35 13 8 13t3.25.387q1.6.388 3.15 1.163.725.375 1.162 1.087Q16 16.35 16 17.2V20Zm8-10q.825 0 1.413-.588Q10 8.825 10 8t-.587-1.412Q8.825 6 8 6q-.825 0-1.412.588Q6 7.175 6 8t.588 1.412Q7.175 10 8 10Zm-6 8h12v-.8q0-.275-.137-.5-.138-.225-.363-.35-1.35-.675-2.725-1.013Q9.4 15 8 15t-2.775.337Q3.85 15.675 2.5 16.35q-.225.125-.362.35-.138.225-.138.5ZM8 8Zm0 10Z"/>
                    </x-svg>
                </x-slot>
                {{ __('Applications') }}
            </x-sidebar-nav-link>
            @endif

        </div>

    </div>
</div>
<div :class="{ '!inline': open }" class="z-30 fixed top-0 left-0 w-screen h-screen bg-gray-900 bg-opacity-30 hidden lg:!hidden transition ease-in-out duration-300 pl-64" @click="open = false"></div>