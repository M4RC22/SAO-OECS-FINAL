@props(['bg' => 'none', 'fill' => 'none'])

@php
  if(session()->has('add') || Helper::isFormCreated()){
      $hasAlert = true;
      $bg = 'bg-green-100 border-semantic-success';
      $fill = 'fill-green-700';
      $textColor = 'text-green-700';
      $message = Helper::getFormCreationMessage() ?? session('add');
  }elseif(session()->has('edit')){
      $bg = 'bg-blue-100 border-primary-blue';
      $hasAlert = true;
      $fill = 'fill-blue-700';
      $textColor = 'text-blue-700';
      $message = session('edit');
  }elseif(session()->has('remove') || session()->has('error')){
      $bg = 'bg-rose-100 border-semantic-warning';
      $hasAlert = true;
      $fill = 'fill-rose-700';
      $textColor = 'text-rose-700';
      $message = session('remove') ?? session('error');
  }else {
    $hasAlert = false;
  }
@endphp


@if($hasAlert)
<div 
    x-cloak
    x-data="{alert: false }" 
    x-show="alert"     
    x-transition:enter="transition ease-out duration-1000"
    x-transition:enter-start="opacity-0 translate-y-6"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-1000"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 translate-y-6"
    x-init="setTimeout( () => alert = true, 500), setTimeout( () => alert = false, 7000)" 
    class="fixed w-auto h-auto top-20 right-5 z-10 rounded-lg border shadow-md {{ $bg }}">
  <div class="p-4 {{ $textColor }}">
    <div class="flex space-x-1">
        <x-svg class="mr-0" color="{{ $fill }}" marginRight="mr-0">
            <path d="M11 17h2v-6h-2Zm1-8q.425 0 .713-.288Q13 8.425 13 8t-.287-.713Q12.425 7 12 7t-.712.287Q11 7.575 11 8t.288.712Q11.575 9 12 9Zm0 13q-2.075 0-3.9-.788-1.825-.787-3.175-2.137-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175 1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138 1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175-1.35 1.35-3.175 2.137Q14.075 22 12 22Zm0-2q3.35 0 5.675-2.325Q20 15.35 20 12q0-3.35-2.325-5.675Q15.35 4 12 4 8.65 4 6.325 6.325 4 8.65 4 12q0 3.35 2.325 5.675Q8.65 20 12 20Zm0-8Z"/>
        </x-svg>
        <p class="text-md"><b>Message: </b>{{ $message }}</p>
    </div>
  </div>
</div>
@endif
