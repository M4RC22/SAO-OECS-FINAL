@php
$Forms = json_encode($forms);
$pendingFormCount = count($forms);
@endphp
<x-app-layout>
  {{-- Row #1 --}}
  <div class="pt-24 px-4 lg:px-8 mb-4">

    <div class="flex flex-wrap gap-2">
       <!-- Card - Pending Forms -->
      <x-dashboard.card-pending-forms name="Total Pending Form:" count="{{ $pendingFormCount }}">
        <path d="M17 22q-2.075 0-3.537-1.462Q12 19.075 12 17q0-2.075 1.463-3.538Q14.925 12 17 12t3.538 1.462Q22 14.925 22 17q0 2.075-1.462 3.538Q19.075 22 17 22Zm1.675-2.625.7-.7L17.5 16.8V14h-1v3.2ZM5 21q-.825 0-1.413-.587Q3 19.825 3 19V5q0-.825.587-1.413Q4.175 3 5 3h4.175q.275-.875 1.075-1.438Q11.05 1 12 1q1 0 1.788.562.787.563 1.062 1.438H19q.825 0 1.413.587Q21 4.175 21 5v6.25q-.45-.325-.95-.55-.5-.225-1.05-.4V5h-2v3H7V5H5v14h5.3q.175.55.4 1.05.225.5.55.95Zm7-16q.425 0 .713-.288Q13 4.425 13 4t-.287-.713Q12.425 3 12 3t-.712.287Q11 3.575 11 4t.288.712Q11.575 5 12 5Z"/>
      </x-dashboard.card-pending-forms>

      <!-- Total Organization -->
      @if(Helper::isSaoHead())
      <x-dashboard.card-pending-forms name="Registered Organizations:" count="{{$orgCount}}">
        <path d="M1 20v-2.8q0-.85.438-1.563.437-.712 1.162-1.087 1.55-.775 3.15-1.163Q7.35 13 9 13t3.25.387q1.6.388 3.15 1.163.725.375 1.162 1.087Q17 16.35 17 17.2V20Zm18 0v-3q0-1.1-.612-2.113-.613-1.012-1.738-1.737 1.275.15 2.4.512 1.125.363 2.1.888.9.5 1.375 1.112Q23 16.275 23 17v3ZM9 12q-1.65 0-2.825-1.175Q5 9.65 5 8q0-1.65 1.175-2.825Q7.35 4 9 4q1.65 0 2.825 1.175Q13 6.35 13 8q0 1.65-1.175 2.825Q10.65 12 9 12Zm10-4q0 1.65-1.175 2.825Q16.65 12 15 12q-.275 0-.7-.062-.425-.063-.7-.138.675-.8 1.037-1.775Q15 9.05 15 8q0-1.05-.363-2.025Q14.275 5 13.6 4.2q.35-.125.7-.163Q14.65 4 15 4q1.65 0 2.825 1.175Q19 6.35 19 8ZM3 18h12v-.8q0-.275-.137-.5-.138-.225-.363-.35-1.35-.675-2.725-1.013Q10.4 15 9 15t-2.775.337Q4.85 15.675 3.5 16.35q-.225.125-.362.35-.138.225-.138.5Zm6-8q.825 0 1.413-.588Q11 8.825 11 8t-.587-1.412Q9.825 6 9 6q-.825 0-1.412.588Q7 7.175 7 8t.588 1.412Q8.175 10 9 10Zm0 8ZM9 8Z"/>
      </x-dashboard.card-pending-forms>
      @endif
    </div>
    

  </div>

    {{-- Row #2 --}}
    <div class="flex flex-col justify-between px-4 lg:space-x-4 lg:flex-row lg:px-8">
      <!-- Calendar -->
      <x-dashboard.calendar forms="{{!! $Forms !!}}"/>

      <!-- Cards - Total Approved -->
      @if($isAcadservOrFinance)
      <div class="flex flex-col justify-start space-y-8  w-1/4">
      @else
      <div class="grid grid-cols-1 mt-4 gap-x-4 sm:grid-cols-2 lg:w-1/4 lg:grid-cols-1 lg:gap-2 lg:mt-0">
      @endif      
          <x-dashboard.card-total-approved name="APF" number="{{$proposalCount}}">
            <path d="M6 22q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h8l6 6v4h-2V9h-5V4H6v16h6v2Zm0-2V4v16Zm12.3-5.475 1.075 1.075-3.875 3.85v1.05h1.05l3.875-3.85 1.05 1.05-4.3 4.3H14v-3.175Zm3.175 3.175L18.3 14.525l1.45-1.45q.275-.275.7-.275.425 0 .7.275l1.775 1.775q.275.275.275.7 0 .425-.275.7Z"/>
          </x-dashboard.card-total-approved>

          <x-dashboard.card-total-approved name="BRF" number="{{$requisitionCount}}">
            <path d="M11 18h2v-1h1q.425 0 .713-.288Q15 16.425 15 16v-3q0-.425-.287-.713Q14.425 12 14 12h-3v-1h4V9h-2V8h-2v1h-1q-.425 0-.712.287Q9 9.575 9 10v3q0 .425.288.712Q9.575 14 10 14h3v1H9v2h2Zm-5 4q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h8l6 6v12q0 .825-.587 1.413Q18.825 22 18 22Zm0-2h12V8.85L13.15 4H6v16Zm0 0V4v16Z"/>
          </x-dashboard.card-total-approved>
          
          @if(!$isAcadservOrFinance)
          <x-dashboard.card-total-approved name="NR" number="{{$narrativeCount}}">
            <path d="M8 20q-.825 0-1.412-.587Q6 18.825 6 18v-3h3v-2.25q-.875-.05-1.662-.388-.788-.337-1.438-1.012v-1.1H4.75L1.5 7q.9-1.15 2.225-1.625Q5.05 4.9 6.4 4.9q.675 0 1.313.1.637.1 1.287.375V4h12v13q0 1.25-.875 2.125T18 20Zm3-5h6v2q0 .425.288.712.287.288.712.288t.712-.288Q19 17.425 19 17V6h-8v.6l6 6V14h-1.4l-2.85-2.85-.2.2q-.35.35-.738.625-.387.275-.812.425ZM5.6 8.25h2.3v2.15q.3.2.625.275.325.075.675.075.575 0 1.038-.175.462-.175.912-.625l.2-.2-1.4-1.4q-.725-.725-1.625-1.088Q7.425 6.9 6.4 6.9q-.5 0-.95.075-.45.075-.9.225ZM8 18h7.15q-.075-.225-.112-.475Q15 17.275 15 17H8Zm0 0v-1 1Z"/>
          </x-dashboard.card-total-approved>
          @endif

          <x-dashboard.card-total-approved name="LF" number="{{$liquidationCount}}">
            <path d="M6 22q-.825 0-1.412-.587Q4 20.825 4 20V4q0-.825.588-1.413Q5.175 2 6 2h9l5 5v13q0 .825-.587 1.413Q18.825 22 18 22Zm0-2h12V8h-4V4H6v16Zm6-1q1.675 0 2.838-1.175Q16 16.65 16 15v-4h-2v4q0 .825-.575 1.413Q12.85 17 12 17q-.825 0-1.412-.587Q10 15.825 10 15V9.5q0-.225.15-.363Q10.3 9 10.5 9q.225 0 .363.137.137.138.137.363V15h2V9.5q0-1.05-.725-1.775Q11.55 7 10.5 7q-1.05 0-1.775.725Q8 8.45 8 9.5V15q0 1.65 1.175 2.825Q10.35 19 12 19ZM6 4v4-4 16V4Z"/>
          </x-dashboard.card-total-approved>


      </div> 

  </div> 

  {{-- Row #3 --}}
  <div class="grid grid-cols-1 gap-4 mt-4 px-4 lg:px-8 md:grid-cols-2">

    <!-- Pre-Event Forms -->
    <div class="bg-white w-auto p-4 shadow-sm">
      <div class="flex flex-wrap justify-center gap-6">

        <div class="w-48 h-48">
          <canvas id="pre-event"></canvas>
        </div>

        <div>
          <p class="text-sm text-bland-400">Approved Pre-Event Forms this Month</p>
          <div class="text-sm text-bland-500 mt-12 space-y-4">

            {{-- APF --}}
            <p class="flex items-center">
              <x-svg color="fill-rose-400" marginRight="mr-1" width="w-3" height="h-3">
                <path d="M12 22q-2.075 0-3.9-.788-1.825-.787-3.175-2.137-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175 1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138 1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175-1.35 1.35-3.175 2.137Q14.075 22 12 22Zm0-2q3.35 0 5.675-2.325Q20 15.35 20 12q0-3.35-2.325-5.675Q15.35 4 12 4 8.65 4 6.325 6.325 4 8.65 4 12q0 3.35 2.325 5.675Q8.65 20 12 20Zm0-8Z"/>
              </x-svg>
               Activity Proposal
              </p>

            {{-- RF --}}
            <p class="flex items-center">
              <x-svg color="fill-blue-400" marginRight="mr-1" width="w-3" height="h-3">
                <path d="M12 22q-2.075 0-3.9-.788-1.825-.787-3.175-2.137-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175 1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138 1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175-1.35 1.35-3.175 2.137Q14.075 22 12 22Zm0-2q3.35 0 5.675-2.325Q20 15.35 20 12q0-3.35-2.325-5.675Q15.35 4 12 4 8.65 4 6.325 6.325 4 8.65 4 12q0 3.35 2.325 5.675Q8.65 20 12 20Zm0-8Z"/>
              </x-svg>
                Budget Requisition
            </p>

          </div>
        </div>
      </div>
    </div>

    <!-- Post-Event Forms -->
    <div class="bg-white w-auto p-4 shadow-sm">
        <div class="flex flex-wrap justify-center gap-6">
  
          <div class="w-48 h-48">
            <canvas id="post-event"></canvas>
          </div>
  
          <div>
            <p class="text-sm text-bland-400">Approved Post-Event Forms this Month</p>
            <div class="text-sm text-bland-500 mt-12 space-y-4">
  
              {{-- APF --}}
              <p class="flex items-center">
                <x-svg color="fill-rose-400" marginRight="mr-1" width="w-3" height="h-3">
                  <path d="M12 22q-2.075 0-3.9-.788-1.825-.787-3.175-2.137-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175 1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138 1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175-1.35 1.35-3.175 2.137Q14.075 22 12 22Zm0-2q3.35 0 5.675-2.325Q20 15.35 20 12q0-3.35-2.325-5.675Q15.35 4 12 4 8.65 4 6.325 6.325 4 8.65 4 12q0 3.35 2.325 5.675Q8.65 20 12 20Zm0-8Z"/>
                </x-svg>
                 Narrative Report
                </p>
  
              {{-- RF --}}
              <p class="flex items-center">
                <x-svg color="fill-blue-400" marginRight="mr-1" width="w-3" height="h-3">
                  <path d="M12 22q-2.075 0-3.9-.788-1.825-.787-3.175-2.137-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175 1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138 1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175-1.35 1.35-3.175 2.137Q14.075 22 12 22Zm0-2q3.35 0 5.675-2.325Q20 15.35 20 12q0-3.35-2.325-5.675Q15.35 4 12 4 8.65 4 6.325 6.325 4 8.65 4 12q0 3.35 2.325 5.675Q8.65 20 12 20Zm0-8Z"/>
                </x-svg>
                  Liquidation Form
              </p>
  
            </div>
          </div>
        </div>
      </div>
  </div>


  <script>
    const preEvent = {
      datasets: [{
        label: 'Approved Pre-Event Forms for The Month',
        data: [{{$monthlyProposalCount}}, {{$monthlyRequisitionCount}},],
        backgroundColor: [
          '#fb7185',
          '#0072E3',
        ],
        hoverOffset: 4
      }]
    };
 
    const preEventConfig = {
      type: 'doughnut',
      data: preEvent,
      options: {}
    };
 
    const preEventChart = new Chart(
      document.getElementById('pre-event'),
      preEventConfig
    );


    const postEvent = {
      datasets: [{
        label: 'Approved Pre-Event Forms for The Month',
        data: [{{$monthlyNarrativeCount}}, {{$monthlyLiquidationCount}}],
        backgroundColor: [
          '#fb7185',
          '#0072E3',
        ],
        hoverOffset: 4
      }]
    };
 
    const postEventConfig = {
      type: 'doughnut',
      data: postEvent,
      options: {}
    };
 
    const postEventChart = new Chart(
      document.getElementById('post-event'),
      postEventConfig
    );

</script>

</x-app-layout>