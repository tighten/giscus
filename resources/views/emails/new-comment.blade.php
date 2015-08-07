<p>You received a new comment on a Gist, <a href="{{ $gist['html_url'] }}">{{ $gist['description'] != '' ? $gist['description'] : '[No Gist title]' }}</a>.</p>

<table>
<tr>
<td style="width: 20%; vertical-align: top; text-align: right; padding-right: 1em;" rowspan="2">
    <img src="{{ $comment['user']['avatar_url'] }}" style="width: 60px; border-radius: 5px;"></td>
</td>
<td style="width: 80%;">
    <p style="margin-top: 0; color: #777;"><a href="{{ $comment['user']['html_url'] }}" style="font-weight: bold; color: #777;">{{ $comment['user']['login'] }}</a>
    commented at <a href="{{ $gist['html_url'] }}#gistcomment-{{ $comment['id'] }}" style="color: #777;">{{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $comment['updated_at'])->format('g:ia \o\n F j, Y') }} GMT</a></p>
</td>
</tr>
<tr>
<td>
    {!! str_replace("\n", "<br>", $comment['body']) !!}
</td>
</tr>
</table>
