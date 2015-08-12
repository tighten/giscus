@extends('layouts.app')

@section('content')
    <p>You love Gists. They're powerful, free, and convenient. But you've probably run into Gists' one big downfall: <strong>No notifications when anyone comments.</strong></p>
    <p class="pitch">Giscus provides the comment notification system your Gists deserve.</p>
    <p>Receive up-to-the-hour notifications on comments on your Gists. No work on your part, free becuase DigitalOcean loves you, cancel any time.</p>
    <div class="pricing well text-center big">
        <p><strong>Free!</strong><br>Sponsored by <a href="http://digitalocean.com/">DigitalOcean</a></p>
    </div>
    <div class="text-center">
        <a href="/auth/github" class="btn btn-default btn-lg github-sign-up-button">
            Sign Up With Github <i class="fa fa-github"></i>
        </a>
    </div>
@stop
