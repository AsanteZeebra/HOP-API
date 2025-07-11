@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('images/lgg.png') }}" class="logo" alt="HOP Logo">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
