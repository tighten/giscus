@extends('layouts.app')

@section('content')
    <div class="row">
        <h2>Account</h2>
        <p>You're signed up to receive notifications of comments on your gists!</p>

        <p>Having any trouble? <a href="mailto:matt@giscus.co">Contact us</a>.</p>

        <br><br><br>

        <h4>Cancel Account</h4>
        <a href="/user/confirm-cancel" class="btn btn-sm btn-danger">Cancel Account <i class="fa fa-exclamation-triangle"></i></a>
    </div>
@stop
