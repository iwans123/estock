@extends('layouts.main_adminkit')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('order.item_list')
        </div>
        <div class="col-md-8">
            @include('order.order_list')
        </div>
    </div>
@endsection
