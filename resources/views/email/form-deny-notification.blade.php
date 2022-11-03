@component('mail::message')
# <p class="deny">We're sorry to say!</p>

@component('mail::panel')
Your form <b>{{$formType}}:
<br>{{$formTitle}}</br></b> has been denied.
<br>
<br>
Remarks: {{$formRemarks}}.
<br>
<br>
To edit form, please  click the button below:
@endcomponent

@component('mail::button', ['url' => URL::route('dashboard')])
Edit Form
@endcomponent

Thanks,<br>
SAO Online Event Creation System
@endcomponent
