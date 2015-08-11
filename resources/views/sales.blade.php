@extends('layouts.app')

@section('content')
    <p>You love Gists. They're powerful, free, and convenient. But you've probably run into Gists' one big downfall: <strong>No notifications when anyone comments.</strong></p>
    <p class="pitch">Giscus provides the comment notification system your Gists deserve.</p>
    <p>Receive up-to-the-hour notifications on comments on your Gists. No work on your part, cheaper than a cup of coffee, cancel any time.</p>
    <div class="pricing well text-center big">
        <p><strong>$12/year</strong><br>for unlimited hourly notifications</p>
    </div>
    <div class="text-center">
        <a href="/auth/github" class="btn btn-default btn-lg github-sign-up-button">
            Sign Up With Github <i class="fa fa-github"></i>
        </a>
    </div>
@stop
