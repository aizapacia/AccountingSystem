<div>
    <h4 class="font-weight-medium">Today's Orders</h4>
    <p class="mb-4">{{ $order['datenow'] }}</p>
    <!-- main content -->
    @if($order['hasval'] == 1)
    <h5>TotalAmount: {{$order['totalAmount']}}</h5>
    <div class="content mt-3">
        <div class="overflow-auto">
            <table class="report-tbl">
                <thead>
                    <tr class="">
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
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Weight</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($order))
                    @forelse($order['as'] as $o)
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
                    @empty
                    <tr>
                        <td colspan="11">
                            <div class="nodata-table">
                                No Data available <i class="bi bi-file-earmark-excel"></i>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- navigation -->
    <div>
        {{$order['today']->links()}}
    </div>
    @else
    <div class="text-center text-info">
        No transaction
    </div>
    @endif
</div>