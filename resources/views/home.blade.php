@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Plans</div>

                <div class="panel-body" id="app">
                    <checkout-form :plans="{{ $plans }}"></checkout-form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Payment</div>

                <div class="panel-body">
                    <ul class="list-group">
                        @foreach(auth()->user()->payments as $payment)
                            <li class="list-group-item">
                                {{ $payment->created_at->diffForHumans() }} : <strong>${{ number_format($payment->amount / 100, 2)}}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
