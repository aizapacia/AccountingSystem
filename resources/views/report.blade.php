@extends('layouts.app')

@section('content')

<section class="row justify-content-center p-2">
    <div class="col-lg-10 shadow section-sm rounded">

        <div class="row">
            <div class="col-md-2 filter d-flex justify-content-center line-b">
                <div style="width: 90%;" class="mt-3 mb-3">
                    <form type="get" action="{{ route('reportSearch') }}">
                        <label>Distibutor Name: </label>
                        <select class="filter-input mb-3" name="disID" required value="{{$dID}}">
                            <option value="0" selected>All Distributor</option>
                            @foreach($disNames as $n)
                            <option value="{{$n->id}}">{{ $n->name }} ({{$n->id}})</option>
                            @endforeach
                        </select>


                        <div class="mb-3">
                            <label>Date By:</label>
                            <select class="filter-input mb-3" name="dateBy" required value="{{$dateby}}">
                                <option selected value="0">Order</option>
                                <option value="1">Delivery</option>
                            </select>
                        </div>

                        <label>Date From: </label>
                        <input type="date" name="fromdate" class="filter-input" required value="{{$fromdate}}">
                        <label>Date To: </label>
                        <input type="date" name="todate" class="filter-input" required value="{{$todate}}">

                        <div class="mt-2 d-flex justify-content-center">
                            <button type="submit" class="main-button">Search</button>
                        </div>
                    </form>
                </div>
            </div><!-- End of Filter -->

            <div class="col-md-10">
                @if($display == 0)
                @include('reports.daily')
                @elseif($display == 1)
                @include('reports.all')
                @else
                @include('reports.specific')
                @endif

            </div><!-- End of Table -->


        </div>

    </div>
</section>

@endsection