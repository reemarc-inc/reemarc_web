@component('mail::message')
# To Do

# A asset is waiting your Action
# Asset Type : {{ $details['asset_type'] }}
# Asset Status : {{ $details['asset_status'] }}
# Assigned to : {{ $details['assignee'] }}

@component('mail::button', ['url' => url($details['url'])])
    Button Text
@endcomponent

Thanks,<br>
KEC Project Manager
@endcomponent
