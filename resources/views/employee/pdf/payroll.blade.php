<html>
<head>
    <title>Payroll</title>
    <!-- @//lang('main.user:email_change_confirmation_email_ignore') -->
</head>
<body>
<h2>EMPLOYEE NAME payroll</h2>
<h3>for DATE - DATE2</h3>

@if (isset($salary))
<h3>Salary</h3>
<p>For period of {{$salary['num_periods']}} {{$salary['wage_period']}}(s) accrued salary is {{$salary['total']}}</p>
@endif

@if (isset($apps) AND !is_null($apps) AND count($apps)>0)
    <?php $appTotal = 0;?>
<h3>Services</h3>
<table>
    <thead>
        <tr>
            <td>Date</td>
            <td>Title</td>
            <td>Client</td>
            <td>List price</td>
            <td>Discount</td>
            <td>Employee percent</td>
        </tr>
    </thead>
    @foreach($apps AS $startDate=>$app)
        <?php $app = reset($app);
        $appTotal = $appTotal + $app['percent_earned'];?>
        <tbody>
            <tr>
                <td>{{$app['start']}}</td>
                <td>{{$app['title']}}</td>
                <td>{{$app['client_name']}}</td>
                <td>{{$app['price']}}</td>
                <td>{{$app['discount']}}</td>
                <td>{{round($app['percent_earned'], 2)}}</td>
            </tr>
        </tbody>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo round($appTotal, 2);?></td>
    </tr>
</table>
@endif


<h3>Products</h3>

<h2>Total: {{$total_wage}}</h2>
</body>
</html>