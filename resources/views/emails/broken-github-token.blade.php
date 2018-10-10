<p>Hey {{ $user->name }},</p>

<p>It seems Giscus is not able to connect to your GitHub account any more. The most likely scenario is that the authorization was revoked on your GitHub settings page.</p>

<p>If this happened due to a mistake, you can simply reconnect your account by visiting the following link: <a href="{{ url('auth/github') }}">{{ url('auth/github') }}</a>. If this was an intentional decision, then no trouble; we're glad to have had you with us.</p>

<p>We hope to see you back soon!</p>
<p>The Giscus team.</p>
