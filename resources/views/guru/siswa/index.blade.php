@foreach($data as $s)
<tr>
<td>{{ $s->nis }}</td>
<td>{{ $s->nama }}</td>
<td>
<a href="/guru/monitoring/{{ $s->nis }}">Input</a>
</td>
</tr>
@endforeach
