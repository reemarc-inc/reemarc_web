@component('mail::message')
# Copy Request

# A asset waiting is your Action
# Asset Type : {{ $details['asset_type'] }}
# Asset Status : {{ $details['asset_status'] }}

@component('mail::button', ['url' => url($details['url'])])
    Button Text
@endcomponent

Thanks,<br>
KEC Project Manager
@endcomponent
