<p>Hi friend!</p>

<p>You received a new comment on a Gist from <a href="{{ $comment['user']['html_url'] }}">{{ '@' . $comment['user']['login'] }}</a>.

<p>Gist: <a href="{{ $gist['html_url'] }}">{{ $gist['description'] }}</a>.</p>
<div style="background: #eee; padding: 1em;">
{!! str_replace("\n", "<br>", $comment['body']) !!}
</div>
<p><a href="{{ $comment['user']['html_url'] }}">{{ '@' . $comment['user']['login'] }}</a>
at <a href="{{ $gist['html_url'] }}#gistcomment-{{ $comment['id'] }}">{{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $comment['updated_at'])->format('F, j Y - g:ia') }}</a></p>
