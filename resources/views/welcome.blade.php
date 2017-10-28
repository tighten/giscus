@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-xs-12">
            <h1 class="welcome-heading">Giscus provides the comment notification system your Gists deserve.</h1>
            <p>You love Gists. They're powerful, free, and convenient. But you've probably run into Gists' one big
                downfall: <strong>No notifications when anyone comments.</strong></p>
            <p>Receive up-to-the-hour notifications on comments on your Gists. No work on your part, free because
                Tighten and DigitalOcean love you, cancel any time.</p>
            <p>
                <a href="/auth/github" class="btn btn-default">
                    <i class="fa fa-github"></i> Sign Up With GitHub
                </a>
            </p>
            <div>
                <h4 class="sponsors-label">Sponsored by</h4>
                <ul class="list-inline">
                    <li><a href="http://digitalocean.com/" class="sponsor">
                        <img src="/digital-ocean-logo.svg" alt="DigitalOcean">
                    </a></li>
                    <li><a href="http://tighten.co/" class="sponsor">
                        <img src="/tighten-logo.svg" alt="Tighten Co.">
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
@stop
