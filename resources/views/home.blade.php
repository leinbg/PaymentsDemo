@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @unless(auth()->user()->isSubscript())
                <div class="panel panel-default">
                    <div class="panel-heading">Create a Subscription</div>

                    <div class="panel-body" id="app">
                        <checkout-form :plans="{{ $plans }}"></checkout-form>
                    </div>
                </div>
            @endunless

            @if (auth()->user()->isSubscript())
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
                <div class="panel panel-default">
                    <div class="panel-heading">Cancel</div>
                    <div class="panel-body">
                        <form method="POST" action="/subscribe">
                            {{ csrf_field() }}
                            {{ method_field("DELETE")}}
                            <button class="btn btn-danger">Cancel My Subscription</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
