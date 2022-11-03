@component('mail::message')
# <p class="suc">Congratulations!</p>
<br>
You have been added to <b>{{$orgName}}</b> 
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
