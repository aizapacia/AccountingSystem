@extends('layouts.app')

@section('content')

<livewire:searchbar />

<h1>Reports</h1>

<div class="p-4">
    <div class="d-flex justify-content-between align-items-center">
        <label class="dname">Order ID: {{ $order['order_log']->id }}</label>
    </div>


    <div class="p-4">


        <label class="sub-h">Distributor Information</label>
        <table>
            <tr>
                <th>Distributor:</th>
                <td>{{ $order['order_log']->distributor_name }}</td>
            </tr>
            <tr>
                <th>DistributorID:</th>
                <td>{{ $order['order_log']->distributor_id }}</td>
            </tr>
            <tr>
                <th>VIP Package: &#160;</th>
                <td>{{ $order['vip_info']['vip_status'] }}</td>
            </tr>
            <tr>
                <th>Contact No.: &#160;</th>
                <td>{{ $order['order_log']->phone }}</td>
            </tr>
            <tr>
                <th>Email: &#160;</th>
                <td>{{ $order['order_log']->email }}</td>
            </tr>
            <tr>
                <th>Area:</th>
                <td>{{ $order['order_address'][1]->area }}</td>
            </tr>
            <tr>
                <th>Address: </th>
                <td>{{ $order['order_address'][1]->address }}</td>
            </tr>
        </table>
        <br>
        <label class="sub-h">Order Information</label>
        <table>
            <tr>
                <th>Order Date: &#160;</th>
                <td>{{ $order['order_log']->order_date }}</td>
            </tr>
            <tr>
                <th>Quantity: </th>
                <td>{{ $order['order_log']->qty }}</td>
            </tr>
            <tr>
                <th>Size:</th>
                <td>00.00 cm</td>
            </tr>
            <tr>
                <th>Weight:</th>
                <td>00 kg</td>
            </tr>
        </table>

        <br>
        <label class="sub-h">Delivery Information</label>
        <table>
            <tr>
                <th>Delivery Date:</th>
                <td>0000</td>
            </tr>
            <tr>
                <th>Delivery Area:</th>
                <td>{{ $order['order_address'][1]->area }}</td>
            </tr>
            <tr>
                <th>Delivery Address: </th>
                <td>{{ $order['order_address'][1]->address }}</td>
            </tr>
        </table>


        <br>
        <label class="sub-h">Driver Information</label>
        <table>
            <tr>
                <th>Driver ID:</th>
                <td>{{ $order['order_log']->driver_id }}</td>
            </tr>
            <tr>
                <th>Driver Name:</th>
                <td>{{ $order['order_log']->driver_name }}</td>
            </tr>
        </table>


        <br><br>



    </div>
</div>



@endsection