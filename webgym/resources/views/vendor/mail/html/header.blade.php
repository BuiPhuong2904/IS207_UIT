@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<h1 style="color: #3869D4;">Grynd Gym</h1>
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
