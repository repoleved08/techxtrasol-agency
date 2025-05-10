<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBlogPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $post;
    public $recentPosts;

    public function __construct(Post $post, $recentPosts)
    {
        $this->post = $post;
        $this->recentPosts = $recentPosts;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function withDelay($notifiable)
    {
        return [
            'mail' => now()->addSeconds(30 * $notifiable->id % 10),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Blog Post: ' . $this->post->title)
            ->greeting('Hello!')
            ->line('We just published a new blog post that might interest you:')
            ->line('**' . $this->post->title . '**')
            ->line($this->post->excerpt)
            ->action('Read Now', route('blog.post', $this->post->slug))
            ->line('Here are some other recent posts you might enjoy:')
            ->view('emails.new-blog-post', [
                'post' => $this->post,
                'recentPosts' => $this->recentPosts
            ]);
    }
}
