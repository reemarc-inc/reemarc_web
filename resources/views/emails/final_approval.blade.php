@component('mail::message')
# Final Approval

# A asset is waiting your Action
# Asset Type : {{ $details['asset_type'] }}
# Asset Status : {{ $details['asset_status'] }}

@component('mail::button', ['url' => url($details['url'])])
    Button Text
@endcomponent

Thanks,<br>
KEC Project Manager
@endcomponent
