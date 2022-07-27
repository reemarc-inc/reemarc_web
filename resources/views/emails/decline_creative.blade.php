@component('mail::message')
# Declined From Creative

# A asset is waiting your Action
# Asset Type : {{ $details['asset_type'] }}
# Asset Status : {{ $details['asset_status'] }}
# Decline Reason : {{ $details['decline_creative'] }}

@component('mail::button', ['url' => url($details['url'])])
    Button Text
@endcomponent

Thanks,<br>
KEC Project Manager
@endcomponent
