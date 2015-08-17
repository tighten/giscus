@extends('layouts.app')

@section('content')
    <p>You love Gists. They're powerful, free, and convenient. But you've probably run into Gists' one big downfall: <strong>No notifications when anyone comments.</strong></p>
    <p class="pitch">Giscus provides the comment notification system your Gists deserve.</p>
    <p>Receive up-to-the-hour notifications on comments on your Gists. No work on your part, free because Tighten and DigitalOcean love you, cancel any time.</p>
    <div class="pricing well text-center big">
        <p>
            <strong>Free!</strong><br>Sponsored by<br>
            <a href="http://digitalocean.com/"><img src="digitalocean-logo.png" alt="DigitalOcean" style="max-width: 25rem"></a><br>
            and<br>
            <a href="http://tighten.co/"><img src="tighten-co-logo.png" alt="Tighten Co." style="max-width: 25rem;"></a>
        </p>
    </div>
    <div class="text-center">
        <a href="/auth/github" class="btn btn-default btn-lg github-sign-up-button">
            <i class="fa fa-github"></i> Sign Up With GitHub
        </a>
    </div>
@stop
