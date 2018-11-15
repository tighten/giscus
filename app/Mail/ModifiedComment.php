<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ModifiedComment extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $gist;
    public $body;
    public $user;

    public function __construct($comment, $gist, $body, $user)
    {
        $this->comment = $comment;
        $this->gist = $gist;
        $this->body = $body;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.edit-comment')
            ->text('emails.edit-comment_plain')
            ->subject('A comment on one of your gists was modified!');
    }
}
