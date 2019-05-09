@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-xs-12">
            <p style="border: 2px solid black; padding: 1em">As of May 8, 2019, GitHub added gist notifications natively. All GitHub users will be automatically subscribed to notifications for all <em>new</em> gists going forward, but you have to manually subscribe to old gists, so for now we've disabled gist comment notifications for all gists created on or after May 8. We're in touch with GitHub and will update our logic as we hear more from them.</p>

            <h1 class="welcome-heading">Giscus provides the comment notification system your Gists deserve.</h1>
            <p>You love Gists. They're powerful, free, and convenient. But you've probably run into Gists' one big
                downfall: <strong>No notifications when anyone comments.</strong></p>

            <p>Receive up-to-the-hour notifications on comments on your Gists. No work on your part, free because
                Tighten {{--and DigitalOcean love--}} loves you, cancel any time.</p>
            <p>
                <form method="post" action="/auth/github">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-github"></i> Sign Up / Log In With GitHub
                    </button>
                    <label class="checkbox-label">
                        <input name="allow-private" type="checkbox" checked>
                        Allow us to access your private Gists (if signing up)
                    </label>
                </form>
            </p>
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
