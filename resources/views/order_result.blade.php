@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h5 class="mb-5 font-weight-medium">Search result for order ID
            <span class="text-primary">{{$id}}</span>
        </h5>
        @if($order != 0)
        <div class="p-5 shadow rounded content">
            <div>
                <a href="{{route('home')}}">BACK</a>
            </div>
            <!-- Date timeline -->
            <div class="stepper-wrapper">
                <div class="stepper-item completed">
                    <div class="step-counter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                            <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                        </svg>
                    </div>
                    <div class="step-name w-500">Order Placed</div>
                    <small class="small-500">{{ date('F j, Y', strtotime($order['order_log']->add_date)) }}</small>
                </div>
                <div class="stepper-item completed">
                    <div class="step-counter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                    </div>
                    <div class="step-name w-500">Order Pickup</div>
                    <small class="small-500">{{ date('F j, Y', strtotime($order['order_log']->pickup_date)) }}</small>
                </div>
                <div class="stepper-item completed">
                    <div class="step-counter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-box2-heart" viewBox="0 0 16 16">
                            <path d="M8 7.982C9.664 6.309 13.825 9.236 8 13 2.175 9.236 6.336 6.31 8 7.982Z" />
                            <path d="M3.75 0a1 1 0 0 0-.8.4L.1 4.2a.5.5 0 0 0-.1.3V15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.1-.3L13.05.4a1 1 0 0 0-.8-.4h-8.5Zm0 1H7.5v3h-6l2.25-3ZM8.5 4V1h3.75l2.25 3h-6ZM15 5v10H1V5h14Z" />
                        </svg>
                    </div>
                    <div class="step-name w-500">Delivered</div>
                    <small class="small-500">{{ date('F j, Y', strtotime($order['order_log']->order_date)) }}</small>
                </div>
            </div>



            <div style="padding:100px">
                <div class="mt-1">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Distributor Info.</h4>
                            <label class="ms-1">
                                <strong>Name:</strong> {{ $order['order_log']->distributor_name }} <br>
                                <strong>ID:</strong> {{ $order['order_log']->id }} <br>
                                <strong>VIP Status:</strong> {{ $order['vip_info']['vip_status'] }}<br>
                                @if($order['vip_info']['vip_status'] != 'Not VIP')
                                <strong>VIP Package:</strong> {{ $order['vip_info']['vip_package'] }}<br>
                                @endif
                            </label>
                        </div>

                        <div class="col-md-6">
                            <h4>Order Info.</h4>
                            <label class="ms-1">
                                <strong>Qty:</strong> {{ $order['order_log']->qty }} <br>
                                <strong>Size:</strong> - <br>
                                <strong>Weight:</strong> - <br>
                            </label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="badge added mb-4">Local delivery</div>
                        <div class="row">
                            <div class="col-6">
                                <h4>Pickup</h4>
                                <div>
                                    <label class="ms-1">
                                        <strong>Area:</strong> {{ $order['order_address'][0]->area }} <br>
                                        <strong>Postal Code:</strong> {{ $order['order_address'][0]->postal_code }} <br>
                                        <strong>Zone:</strong> {{ $order['order_address'][0]->zone }} <br>
                                        <strong>Address:</strong> {{ $order['order_address'][0]->address }} <br>
                                    </label>
                                </div>
                            </div>

                            <div class="col-6">
                                <h4>Delivery</h4>
                                <div>
                                    <label class="ms-1">
                                        <strong>Area:</strong> {{ $order['order_address'][1]->area }} <br>
                                        <strong>Postal Code:</strong> {{ $order['order_address'][1]->postal_code }} <br>
                                        <strong>Zone:</strong> {{ $order['order_address'][1]->zone }} <br>
                                        <strong>Address:</strong> {{ $order['order_address'][1]->address }} <br>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h5 class="mt-3">Driver Info.</h5>
                        <div>
                            <label class="ms-1">
                                <strong>Name:</strong> {{ $order['order_log']->driver_name }} <br>
                                <strong>ID:</strong> {{ $order['order_log']->driver_id }} <br>
                            </label>
                        </div>
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