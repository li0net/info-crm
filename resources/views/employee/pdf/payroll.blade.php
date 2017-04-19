<html>
<head>
    <title>Payroll</title>
    <!-- @//lang('main.user:email_change_confirmation_email_ignore') -->
</head>
<body>
<h2>{{$employee_name}} payroll</h2>
<h3>for {{date('Y-m-d H:i', strtotime($period_start))}} - {{date('Y-m-d H:i', strtotime($period_end))}}</h3>

@if (isset($salary))
<h3>Salary</h3>
<p>For period of {{$salary['num_periods']}} {{$salary['wage_period']}}(s) accrued salary is {{$salary['total']}}</p>
@endif

@if (isset($apps) AND !is_null($apps) AND count($apps)>0)
    <?php $appTotal = 0;?>
<h3>Services</h3>
<table cellpadding="5" border="1" style="border: 1px solid black; border-collapse: collapse;">
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
                <td>{{date('Y-m-d H:i', strtotime($app['start']))}}</td>
                <td>{{str_limit($app['title'], 20)}}</td>
                <td>{{str_limit($app['client_name'], 30)}}</td>
                <td>{{$app['price']}}</td>
                <td>{{$app['discount']}}</td>
                <td align="right">{{round($app['percent_earned'], 2)}}</td>
            </tr>
        </tbody>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="font-weight: bold" align="right"><?php echo round($appTotal, 2);?></td>
    </tr>
</table>
@endif

@if (isset($products) AND !is_null($products) AND count($products)>0)
    <?php $productTotal = 0; ?>
<h3>Products</h3>
<table cellpadding="5" border="1" style="border: 1px solid black; border-collapse: collapse;">
    <thead>
    <tr>
        <td>Date</td>
        <td>Product title</td>
        <td>Price payed</td>
        <td>Employee percent</td>
    </tr>
    </thead>
    @foreach($products AS $startDate=>$product)
        <?php $product = reset($product);
        $productTotal = $productTotal + $product['percent_earned'];?>
        <tbody>
        <tr>
            <td>{{date('Y-m-d H:i', strtotime($product['date']))}}</td>
            <td>{{str_limit($product['product_title'], 20)}}</td>
            <td>{{round($product['amount'], 2)}}</td>
            <td align="right">{{round($product['percent_earned'], 2)}}</td>
        </tr>
        </tbody>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td style="font-weight: bold" align="right"><?php echo round($productTotal, 2);?></td>
    </tr>
</table>
@endif

<br/>
<table width="100%" cellpadding="20">
    <tr>
        <td align="right"><h2>Total: {{$total_wage}}</h2></td>
    </tr>
</table>
</body>
</html>