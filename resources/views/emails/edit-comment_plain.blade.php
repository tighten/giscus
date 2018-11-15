<?php
    $date = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $comment['updated_at']);
?>

A comment has been edited on a Gist,

{{ $gist['description'] != '' ? $gist['description'] : '[No Gist title]' }}

{{ $comment['user']['login'] }} commented {{ $date->diffForHumans() }}

{!! $body !!}

Want to stop receiving these notifications? Visit the link below.

{{ $user->getUnsubscribeUrl() }}
