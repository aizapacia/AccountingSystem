@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        @if($order != 0)
        <div class="p-5 shadow rounded content">
            <div>
                <a href="/search/distributor?ID={{$id}}">BACK</a>
            </div>
            <div class="mt-3 p-3">
                <div class="mt-3">
                    <table>
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Order Date</th>
                                <th>Delivery Date</th>
                                <th>Local/OutState</th>
                                <th>Quantity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($order != 0)
                            @foreach($order['val'] as $o)
                            <tr>
                                <td> {{ $o['id'] }} </td>
                                <td> {{ $o['add_date'] }} </td>
                                <td> {{ $o['order_date'] }} </td>
                                <td> {{ $o['islocal'] }} </td>
                                <td> {{ $o['qty'] }} </td>
                                <td> {{ $o['status'] }} </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6">
                                    <div class="nodata-table">
                                        No order transaction <i class="bi bi-file-earmark-excel"></i>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div>
                        @if($order != 0)
                        {{ $order['link']->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="p-5 shadow rounded">
            <div style="background: white; margin-top:10px;" class="p-3">
                <div class="text-center">
                    <img class="img-fluid" src="{{url('template/images/no-search-found.png')}}">
                    <h3>No result found</h3>
                    <a href="{{route('home')}}">
                        <button class="btn btn-primary mt-2">Back to home</button>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endsection