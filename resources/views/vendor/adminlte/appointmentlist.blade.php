@foreach($appointments as $appointment)
	<tr>
		<th>{{ $appointment->appointment_id }}</th>
		<td>{{ $appointment->employee_id }}</td>
		<td>{{ $appointment->client_id }}</td>
		<td>{{ $appointment->service_id }}</td>
		<td>{{ $appointment->start }}</td>
		<td>{{ $appointment->end }}</td>
	</tr>
@endforeach