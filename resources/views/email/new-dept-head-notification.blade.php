@component('mail::message')
# <p class="suc">Congratulations!</p>
<br>
You has been assigned as <b>Department Head for {{$dept}}.</b>
<br>
@component('mail::panel')
If you wish to login to your account, kindly click the button below:
@endcomponent

@component('mail::button', ['url' => 'http://127.0.0.1:8000/'])
Login
@endcomponent

Thanks,<br>
SAO Online Event Creation System
@endcomponent
