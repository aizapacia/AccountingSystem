<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            width: 1056px;
            text-align: center;
            font-size: 15px;
        }

        div {
            width: 100%;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        td {
            height: 20px;
            border: 1px solid gray;
        }

        th {
            border: 1px solid gray;
        }
    </style>
</head>

<body>
    <div>
        <center>
            <strong>
                <h3>GoBuilders Netsoft Sdn Bhd</h3>
                <label class="pt">
                    B2C Report
                </label>
            </strong>
            </p>
        </center>


        <table style="table-layout:fixed; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Delivery Date</th>
                    <th>Distributor ID</th>
                    <th>Distributor Name</th>
                    <th>VIP Package</th>
                    <th>Driver ID</th>
                    <th>Drive Name</th>
                    <th>Local / Outstate</th>
                    <th>Pickup Charge</th>
                    <th>Qty</th>
                    <th>Size</th>
                    <th>Weight</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>
                @if(!empty($order['as']))
                @foreach($order['as'] as $o)
                <tr>
                    <td>{{ $o['order_id'] }}</td>
                    <td>{{ $o['add_date'] }}</td>
                    <td>{{ $o['delivery_date'] }}</td>
                    <td>{{ $o['distributor_id'] }}</td>
                    <td>{{ $o['distributor_name'] }}</td>
                    <td>{{ $o['vip_package'] }}</td>
                    <td>{{ $o['driver_id'] }}</td>
                    <td>{{ $o['driver_name'] }}</td>
                    <td>{{ $o['local_int'] }}</td>
                    <td>RM{{ $o['pickup_charge'] }}</td>
                    <td>{{ $o['qty'] }}</td>
                    <td>RM{{ $o['over_size'] }}</td>
                    <td>RM{{ $o['over_weight'] }}</td>
                    <td style="font-weight: 500;">RM{{ $o['amount'] }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="14">
                        <h6 class="text-right">
                            Total Amount: RM {{$order['totalAmount']}}
                        </h6>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>




    </div>
</body>

</html>