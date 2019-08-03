<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewComment extends Mailable
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
        return $this->view('emails.new-comment')
            ->text('emails.new-comment_plain')
            ->subject('You have a new Gist Comment!');
    }
}
