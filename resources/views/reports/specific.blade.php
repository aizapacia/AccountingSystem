<div>
    @if(!empty($order['user']))
    <h4 class="mainheader">Name:{{ $order['user']->name }}</h4>
    <h6>
        ID: {{ $order['user']->id }} <br>
        VIP Package:
    </h6>
    @else

    @endif
    <div class="row">
        <div class="col-md-6">
            <p class="mb-4">
                <strong>Date Start:</strong> {{ $fromdate }} <br>
                <strong>Date Start:</strong> {{ $todate }}
            </p>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <form type="get" action="{{ route('download', [
                'dID' => $dID,
                'dateby' => $dateby,
                'fdate' => $fromdate,
                'tdate' => $todate
                ]) }}">
                <select name="fileType" id="fileType" class="select-dl" required>
                    <option value="pdf">pdf</option>
                    <option value="xlsx">xlsx</option>
                    <option value="csv">csv</option>
                </select>
                <button class="select-btn" type="submit">
                    Download
                </button>
            </form>
        </div>
    </div>
    <!-- main content -->
    <div class="content mt-3">
        <div class="overflow-auto">
            <table class="report-tbl">
                <thead>
                    <tr class="">
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Driver ID</th>
                        <th>Drive Name</th>
                        <th>Local / Outstate</th>
                        <th>Pickup Charge</th>
                        <th>Quantity</th>
                        <th>Over Size</th>
                        <th>Over Weight</th>
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
                                Page total: RM {{$order['pagetotal']}}
                            </h6>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="14">
                            <h6 class="text-right">
                                Overall total: RM {{$order['totalAmount']}}
                            </h6>
                        </td>
                    </tr>

                    @else
                    <tr>
                        <td colspan="11">
                            <div class="nodata-table">
                                No Data available <i class="bi bi-file-earmark-excel"></i>
                            </div>
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
    <!-- navigation -->
    <div>
        {{$order['today']->appends(
            ['disID' => $dID,
            'dateBy' => $dateby,
            'fromdate' => $fromdate,
            'todate' => $todate]
            )->links()}}
    </div>
</div>