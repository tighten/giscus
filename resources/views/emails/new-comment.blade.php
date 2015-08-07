<p>You received a new comment on a Gist, <a href="{{ $gist['html_url'] }}">{{ $gist['description'] != '' ? $gist['description'] : '[No Gist title]' }}</a>.</p>

<table>
    <tr>
        <td style="width: 20%; vertical-align: top; text-align: right; padding-right: 0.5em;">
            <img src="{{ $comment['user']['avatar_url'] }}&s=96" style="width: 48px; border-radius: 5px;"></td>
        </td>
        <td style="width: 80%;">
            <div style="border: 1px solid #bfccd1; border-radius: 3px;">
                <div style="padding: 0.75em 1em; background: #f2f8fa; border-top-left-radius: 3px; border-top-right-radius: 3px; border-bottom: 1px solid #dde4e6;">
                    <a href="{{ $comment['user']['html_url'] }}" style="font-weight: bold; color: #555;">{{ $comment['user']['login'] }}</a>
                    commented
<?php
    $date = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $comment['updated_at']);
?>
                    <a href="{{ $gist['html_url'] }}#gistcomment-{{ $comment['id'] }}" style="color: #555;" title="{{ $date->format('g:ia \o\n F j, Y') }} GMT">{{ $date->diffForHumans() }}</a>
                </div>
                <div style="padding: 1em;">
                    {!! str_replace("\n", "<br>", $comment['body']) !!}
                </div>
            </div>
        </td>
    </tr>
</table>
