@component('mail::message')

# You got a new message from {{ $details['who'] }}

@component('mail::panel')
{{ $details['message'] }}
@endcomponent

@component('mail::button', ['url' => url($details['url']),'color' => 'error'])
Go to Asset
@endcomponent

Thanks,<br>
KDO Project Manager
@endcomponent
