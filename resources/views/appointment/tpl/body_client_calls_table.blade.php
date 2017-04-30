<h4>Calls history</h4>
<table class="table table-hover table-condensed" id="table_calls">
    <thead>
        <tr>
            <th class="text-center" width="10%">#</th>
            <th width="20%" >Date</th>
            <th>Title</th>
        </tr>
    </thead>
    <tbody>
        @foreach($calls as $call)
        <tr id="tr_{{ $call->id }}">
            <th class="text-center">
                <a href="#" data-id="{{ $call->id }}" class="table-action-link"><i class='fa fa-eye'></i></a>
                <div class="hidden td_description">{{ $call->description }}</div>
            </th>
            <td class="td_date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $call->date)->format('Y-m-d') }}</td>
            <td class="td_title">{{ $call->title }}</td>
        </tr>
        @endforeach
    </tbody>
</table>