@component('mail::message')
# <p class="suc">You received a Student Organization Application.</p>
<br>
There's a new <b>Student Organization Application</b> that needs an approval submitted by <b>{{$orgApplicant}}</b>.
<br>

@component('mail::panel')
Please take note that you only have 3 days to approve.
<br>
<br>
<br>
To view the Student Organization Applciation, kindly click the button below:
@endcomponent

@component('mail::button', ['url' => URL::route('org-application.index')])
View Application
@endcomponent

Thanks,<br>
SAO Online Event Creation System
@endcomponent
