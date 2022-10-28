@component('mail::message')

# Hi {{ $details['who'] }},
<b>Today(2022-10-28)</b> is <b style="color: #b91d19">Copy Review Start Date</b> for Asset #{{ $details['a_id'] }}
@component('mail::panel')
Project name here!
<b style="color: #b91d19">Copy Review Start Date</b>
@endcomponent

@component('mail::table')
| TYPE          | STATUS        | Asset ID  |
| ------------- |:-------------:| ---------:|
| Email Blast   | Copy Reivew | 5152 |
@endcomponent

@component('mail::button', ['url' => '/admin/campaign/1595/edit#5152','color' => 'error'])
Go to Asset
@endcomponent

Thanks,<br>
KOE Project Manager
@endcomponent
