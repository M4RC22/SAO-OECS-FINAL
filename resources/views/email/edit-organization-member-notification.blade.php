@component('mail::message')
# <p class="suc">Permission changed!</p>
<br>
Your privilege to <b>{{$orgName}}</b> have been changed.
<br>

@component('mail::panel')
Position: <b>{{$position}}</b>
<br>
Role: <b>{{$role}}</b>
<br>
<br>
<br>
To view your student organization, kindly click the button below:
@endcomponent

@component('mail::button', ['url' => URL::route('organization.index')])
View Organization
@endcomponent

Thanks,<br>
SAO Online Event Creation System
@endcomponent
