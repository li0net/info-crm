<div class="row">
    @if ($clientData['num_visits'] === 0)
        <div class="col-sm-12">
            <h3>No client visits data</h3>
        </div>
    @else
        <div class="col-sm-12">
            <h3>Client Statistics</h3>
            <p><b>@lang('main.appointment:client_num_visits'):&nbsp;</b>{{$clientData['num_visits']}}</p>
            <p><b>@lang('main.appointment:client_last_visit_date'):&nbsp;</b>{{date('Y.m.d H:i', strtotime($clientData['last_visit']))}}</p>
        </div>
        <div class="col-sm-12">
            <hr>
        </div>
        <div class="col-sm-12">
            <h3>Visits history</h3>
            <table class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th class="text-center" width="10%">#</th>
                    <th>Employee</th>
                    <th>Service</th>
                    <th width="15%">Date Start</th>
                    <th width="15%">Date End</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($clientData['history'] as $visit)
                    <tr>
                        <th class="text-center">
                            <a target="_blank" href="/appointments/edit/{{ $visit->appointment_id }}" data-id="{{ $visit->appointment_id }}" class="table-action-link"><i class='fa fa-eye'></i></a>
                        </th>
                        <td>{{ $visit->employee }}</td>
                        <td>{{ $visit->service }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $visit->start)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $visit->end)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>