<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Communication extends Mailable
{
    use Queueable, SerializesModels;

    protected $template;
    protected $user;
    protected $data;
    protected $annexes;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->template = $data->template;
        $this->user = $data->user;
        $this->subject = $data->subject;
        $this->annexes = $data->annexes ?? [];
        $this->data = $data->data;
    }

    public function content(): Content
    {
        return new Content(
            view: $this->template,
            text: $this->template .  "-text",
            with: $this->data,
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this;
        if(count($this->annexes)) {
            foreach($this->annexes as $annexe) {
                $mail = $mail->attachData($annexe->data, $annexe->name, [ "mime" => $annexe->type ]);
            }
        }
        return $mail->content();
    }

}
