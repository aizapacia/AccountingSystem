@extends('layouts.app')

@section('content')
<!-- banner -->
<section class="section pb-0">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-7 text-center text-lg-left">
                <h1 class="mb-4">Accounting System</h1>
                <p></p>

                <div class="d-flex justify-content-center">
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                        <button id="btna" onclick="myFunction('order')" class="btn btn-sm btn-outline-primary active">Order</button>
                        <button id="btnd" onclick="myFunction('distributor')" class="btn btn-sm btn-outline-primary">Distributor</button>
                    </div>
                </div>

                <div class="search-wrapper">

                    <form type="get" action="{{ route('quickSearch',['searchby' => 'order']) }}" id="order">
                        <input required name="ID" type="search" class="form-control form-control-lg" placeholder="Search order ID...">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                    <form type="get" required action="{{ route('quickSearch',['searchby' => 'distributor']) }}" style="display: none; " id="distributor">
                        <select class="form-control form-control-lg p-1" name="ID" style="height:70px;">
                            <option selected disabled>Select distributor name</option>
                            @if($Dnames != null)
                            @foreach($Dnames as $d)
                            <option value="{{$d->id}}">
                                @if(strlen($d->name) > 1)
                                {{ $d->name }}
                                @else
                                {{ $d->username }} [{{ $d->id }}]
                                @endif
                            </option>
                            @endforeach
                            @endif
                        </select>
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>

            </div>
            <div class="col-lg-4 d-lg-block d-none">
                <img src="{{ url('/template/images/banner.jpg') }}" alt="illustration" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<!-- /banner -->
@endsection

@section('scripts')
<script>
    function myFunction(val) {
        var o = document.getElementById("order");
        var d = document.getElementById("distributor");

        if (val === "order") {
            o.style.display = "block";
            d.style.display = "none";
            document.getElementById("btna").classList.add("active");
            document.getElementById("btnd").classList.remove("active");
        } else {
            d.style.display = "block";
            o.style.display = "none";
            document.getElementById("btna").classList.remove("active");
            document.getElementById("btnd").classList.add("active");
        }
    }
</script>
@endsection