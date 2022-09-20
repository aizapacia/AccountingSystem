@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h5 class="mb-5 font-weight-medium">Search result for distributor
            <span class="text-primary">{{$id}}</span>
        </h5>
        @if($dis != 0)
        <div class="p-5 shadow rounded content">
            <div>
                <a href="{{route('home')}}">BACK</a>
            </div>
            <div style="padding-left:50px; padding-right:50px;">
                <h3 class="mainheader">{{ $dis['dis_info']->first_name }} {{ $dis['dis_info']->last_name }}</h3>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="ms-1">
                            <strong>ID:</strong> {{ $dis['dis_info']->id }} <br>
                            <strong>Contact No.:</strong> {{ $dis['dis_info']->first_name }} <br>
                            @if($dis['vip_info']['vip_status'] == 'Not VIP')
                            <strong>Vip Package:</strong> - <br>
                            @else
                            <strong>Vip Package:</strong> {{ $dis['vip_info']['vip_package'] }} <br>
                            @endif
                        </label>
                        <br>
                        <label class="ms-1"><strong>Status</strong></label>

                    </div>

                    <div class="col-md-6">
                        <label>
                            <strong>Address Unit:</strong> {{ $dis['dis_info']->address }} <br>
                            <strong>City:</strong> {{ $dis['dis_info']->city }} <br>
                            <strong>State:</strong> {{ $dis['dis_info']->state }} <br>
                            <strong>Zip Code:</strong> {{ $dis['dis_info']->zipcode }}
                        </label>
                    </div>
                </div>
            </div>


            <div class="mt-3 p-3">
                <h6 class="subheader">Transaction History</h6>
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
                            @if($dis['disOrder'] != 0)
                            @foreach($dis['disOrder']['val'] as $o)
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
                    <div class="text-center">
                        @if($dis['disOrder'] != 0)
                        @if( $dis['disOrder']['total'] > 10)
                        <a href="{{route('disTable',['id' => $id])}}">
                            view more transaction
                        </a>
                        @endif
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