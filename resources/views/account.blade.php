@extends('layouts.app')

@section('content')
    <div class="row">
        <h2>Account</h2>

        <h3>Invoices</h3>
        <ul>
        @foreach (Auth::user()->invoices() as $invoice)
            <li>{{ $invoice->dateString() }} |
                {{ $invoice->dollars() }} |
                <a href="/user/invoice/{{ $invoice->id }}">Download</a></li>
        @endforeach
        </ul>

        <h3>Cancel Subscription</h3>
        <a href="/user/confirm-cancel" class="btn btn-danger">Cancel Subscription <i class="fa fa-exclamation-triangle"></i></a>
    </div>
@stop
