@extends('layouts.app')

@section('content')
    <div class="row">
        <h2>Account</h2>
        <p>You are currently subscribed to a $3/month plan with Giscus.</p>

        <h3>Invoices</h3>
        <ul>
        @foreach (Auth::user()->invoices() as $invoice)
            <li>{{ $invoice->dateString() }} |
                {{ $invoice->dollars() }} |
                <a href="/user/invoice/{{ $invoice->id }}">Download</a></li>
        @endforeach
        </ul>

        <br><br><br><br>

        <h4>Cancel Subscription</h4>
        <a href="/user/confirm-cancel" class="btn btn-sm btn-danger">Cancel Subscription <i class="fa fa-exclamation-triangle"></i></a>
    </div>
@stop
