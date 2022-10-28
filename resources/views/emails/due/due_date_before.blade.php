@component('mail::message')

# Hi {{ $details['who'] }},
<b>Tomorrow</b>
<span style="color:#ffffff; font-size: medium;background-color: #933434;border-radius: 6px;">
&nbsp;{{ $details['due'] }}&nbsp;
</span> &nbsp; is
<b style="color: #b91d19">Copy Review Start Date</b> for Asset

@component('mail::table')
    | TYPE          | Asset ID  |
    | :------------: | :---------:|
    | Email Blast   | 5152 |
@endcomponent

@component('mail::panel')
    Project name here!
@endcomponent

@component('mail::button', ['url' => url($details['url']),'color' => 'error'])
    Go to Asset
@endcomponent

Thanks,<br>
KOE Project Manager
@endcomponent
