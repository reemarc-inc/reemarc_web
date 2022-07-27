@component('mail::message')
# Declined From Copy Request

# A asset is waiting your Action
# Asset Type : {{ $details['asset_type'] }}
# Asset Status : {{ $details['asset_status'] }}
# Decline Reason : {{ $details['decline_copy'] }}

@component('mail::button', ['url' => url($details['url'])])
    Button Text
@endcomponent

Thanks,<br>
KEC Project Manager
@endcomponent
