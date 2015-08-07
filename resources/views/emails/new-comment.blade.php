<p>You received a new comment on a Gist, <a href="{{ $gist['html_url'] }}">{{ $gist['description'] != '' ? $gist['description'] : '[No Gist title]' }}</a>.</p>

<table>
<tr>
<td style="width: 20%; vertical-align: top; text-align: right; padding-right: 1em;">
    <img src="{{ $comment['user']['avatar_url'] }}" style="width: 100px;"></td>
</td>
<td style="width: 80%;">
    <p><a href="{{ $comment['user']['html_url'] }}" style="font-weight: bold;">{{ '@' . $comment['user']['login'] }}</a></p>

    {!! str_replace("\n", "<br>", $comment['body']) !!}

    <p style="color: #777;"><a href="{{ $gist['html_url'] }}#gistcomment-{{ $comment['id'] }}" style="color: #777;">{{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $comment['updated_at'])->format('F j, Y - g:ia') }} GMT</a></p>
</td>
</tr>
</table>
