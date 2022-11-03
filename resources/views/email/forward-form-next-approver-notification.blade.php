@component('mail::message')
# <p class="suc">The <b>{{$formType}}</b> was forwarded to the <b>{{$nextApprover}}.</p>
<br>
The form will be reviewed by <b>{{$nextApprover}}</b> 

@component('mail::panel')
Event: {{$formTitle}}
<br>
Please wait for 1-3 days for approval.
<br>
<br>
To view the status of your <b>{{$formType}}</b>, please click the button below:
@endcomponent

@component('mail::button', ['url' => URL::route('dashboard')])
View Status
@endcomponent

Thanks,<br>
SAO Online Event Creation System
@endcomponent
