@component('mail::message')

# Hi {{ $details['who'] }},

<b style="color: #b91d19">{{ $details['asset_status'] }} Start Date</b>
<span style="color:#ffffff; font-size: medium;background-color: #933434;border-radius: 6px;">&nbsp;{{ $details['due'] }}&nbsp;</span> is over due

@component('mail::table')
| TYPE          | Asset ID  |
| :------------: | :---------:|
| {{ $details['asset_type'] }}   | {{ $details['a_id'] }} |
@endcomponent

@component('mail::panel')
{{ $details['task_name'] }}
@endcomponent

@component('mail::button', ['url' => url($details['url']),'color' => 'error'])
Go to Asset
@endcomponent

Thanks,<br>
KOE Project Manager
@endcomponent
