@component('mail::message')
# <p class="suc">The <b>{{$formType}}</b> has been approved!</p>
<br>


@component('mail::panel')
Thank you for using SAO-OECS.
<br>
<br>
To view details of your <b>{{$formType}}</b>, please click the button below:
@endcomponent

@component('mail::button', ['url' => URL::route('dashboard')])
View Form
@endcomponent

Thanks,<br>
SAO Online Event Creation System
@endcomponent




