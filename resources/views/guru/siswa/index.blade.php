@foreach($data as $s)
<tr>
<td>{{ $s->nis }}</td>
<td>{{ $s->nama }}</td>
<td>
<a href="/guru/monitoring/{{ $s->id }}">Input</a>
</td>
</tr>
@endforeach
