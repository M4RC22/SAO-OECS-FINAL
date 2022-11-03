@component('mail::message')
# <p class="suc">The <b>{{$formType}}</b> is ready for approval!</p>
<br>


@component('mail::panel')
Event: {{$formTitle}}
<br>
Please approve within 1-3 days.
<br>
<br>
To review the <b>{{$formType}}</b>, please click the button below:
@endcomponent

@component('mail::button', ['url' => URL::route('submitted-forms.index')])
Review Form
@endcomponent

Thanks,<br>
SAO Online Event Creation System
@endcomponent
