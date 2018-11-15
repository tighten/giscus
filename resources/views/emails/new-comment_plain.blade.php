<?php
    $date = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $comment['updated_at']);
?>

You received a new comment on a Gist,

{{ $comment['user']['login'] }} commented {{ $date->diffForHumans() }}

{!! $body !!}

Want to stop receiving these notifications? Visit the link below.

{{ $user->getUnsubscribeUrl() }}
