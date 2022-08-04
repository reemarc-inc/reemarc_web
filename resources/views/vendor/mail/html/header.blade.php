<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="<?php echo e(asset('/storage/KEC-PM.png')); ?>" class="logo" alt="Laravel Logo" style="width: 100%;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
