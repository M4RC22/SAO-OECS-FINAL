@component('mail::message')
# <p class="deny">We are sorry...</p>
<br>
Your Student Organization Application for <b>{{$orgName}}</b> has been denied.
<br>
@component('mail::panel')
If you wish to apply for a Student Organization again, kindly click the button below:
@endcomponent

@component('mail::button', ['url' => URL::route('dashboard')]) 
Apply Organization
@endcomponent

Thanks,<br>
SAO Online Event Creation System
@endcomponent
