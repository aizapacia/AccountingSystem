@extends('layouts.app')

@section('content')

<!-- details page -->
<section class="pt-5">
    <div class="container shadow section-sm rounded">
        <div class="row">
            <!-- body -->
            <div class="col-lg-12">
                <div class="px-lg-5 px-4">
                    <h4 class="mb-4 font-weight-medium">Distributor Information</h4> <!-- main content -->

                    @livewire('distributor')

                </div>
            </div>
        </div>
    </div>
</section>
<!-- /details page -->
@endsection