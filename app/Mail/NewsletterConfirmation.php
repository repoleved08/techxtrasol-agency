<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirmation extends Mailable
{
  use Queueable, SerializesModels;

  public $subscriber;

  public function __construct(NewsletterSubscriber $subscriber)
  {
    $this->subscriber = $subscriber;
  }

  public function envelope()
  {
    return new Envelope(
      subject: 'Confirm Your Newsletter Subscription',
    );
  }

  public function content()
  {
    return new Content(
      markdown: 'emails.newsletter.confirmation',
      with: [
        'url' => route('newsletter.confirm', $this->subscriber->token),
        'unsubscribeUrl' => route('newsletter.unsubscribe', $this->subscriber->email)
      ]
    );
  }
}
