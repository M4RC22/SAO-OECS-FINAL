@props(['id', 'eventTitle', 'orgName', 'formType'])

@php
    $formTypes = [ 'APF' => 'Activity Proposal Form', 'BRF' => 'Budget Requisition Form', 'NR' => 'Narrative Report', 'LF' => 'Liquidation Form'];
    
    $id = (substr($id, 1, -1));
    $eventTitle = (substr($eventTitle, 1, -1));
    $orgName = (substr($orgName, 1, -1));
    $formType = (substr($formType, 1, -1));
    
@endphp
<x-modal name="approveForm" width="w-[500px]">
    <div class="text-sm text-bland-600 text-left py-5">
        By clicking <span class="bg-semantic-success text-white rounded-md px-1">
            Confirm</span>, I am confident enough to give my approval to <b>{{ $orgName }} </b> 
            for their form <b>{{ $eventTitle }} - {{ $formTypes[$formType] }}</b>, since I don't see any typographical error and no 
            violation committed.
    </div>

    <div class="flex justify-end space-x-2 mt-2">
        <form action="{{ route('submitted-forms.approve', ['forms' => $id ]) }}" method="POST">
            @csrf
            @method('PUT')
            <x-button bg="bg-semantic-success" hover="hover:bg-green-600" type="submit" >
                {{ __('Confirm') }}
                
            </x-button>
        </form>

        <x-button bg="bg-semantic-danger" hover="hover:bg-rose-600" @click="approveForm = false, modal = false" >
                {{ __('Cancel') }}
        </x-button>
    </div>
</x-modal>