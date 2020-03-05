@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-xs-12">
            <p style="border: 2px solid black; padding: 1em">As of May 8, 2019, <a href="https://github.blog/changelog/2019-06-03-authors-subscribed-to-gists/">GitHub added gist notifications natively</a>. We're disabling the service, but keeping the site up for posterity.</p>

            <h1 class="welcome-heading">Giscus provides the comment notification system your Gists deserve.</h1>
            <p>You love Gists. They're powerful, free, and convenient. But you've probably run into Gists' one big
                downfall: <strong>No notifications when anyone comments.</strong></p>

            <p>Receive up-to-the-hour notifications on comments on your Gists. No work on your part, free because
                Tighten {{--and DigitalOcean love--}} loves you, cancel any time.</p>
            <div>
                <h4 class="sponsors-label">Sponsored by</h4>
                <ul class="list-inline">
                    {{--
                    <li><a href="http://digitalocean.com/" class="sponsor">
                        <img src="/digital-ocean-logo.svg" alt="DigitalOcean">
                    </a></li>
                    --}}
                    <li><a href="https://tighten.co/" class="sponsor">
                        <img src="/tighten-logo.svg" alt="Tighten">
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
@stop
