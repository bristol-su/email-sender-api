<?php

namespace App\Mail;

use App\EmailAddress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DefaultMailable extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var EmailAddress
     */
    public $emailAddress;

    public $content;

    public $subject;

    public $uploadedAttachments;

    /**
     * Create a new message instance.
     *
     * @param EmailAddress $emailAddress
     * @param string $content
     * @param string $subject
     * @param array $attachments
     */
    public function __construct(EmailAddress $emailAddress, $content = '', $subject = '', $attachments = [])
    {
        $this->emailAddress = $emailAddress;
        $this->content = $content;
        $this->subject = $subject;
        $this->uploadedAttachments = $attachments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        foreach($this->uploadedAttachments as $attachment) {
            $this->attach($attachment->getRealPath(),
                [
                    'as' => $attachment->getClientOriginalName(),
                    'mime' => $attachment->getClientMimeType(),
                ]);
        }
        return $this->from($this->emailAddress->email)
            ->subject($this->subject)
            ->view('email.email');

    }
}
