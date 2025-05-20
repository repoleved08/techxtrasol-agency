<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBlogPostNotification extends Notification implements ShouldQueue
{
  use Queueable, SerializesModels;

  protected int $postId;
  protected array $recentPostIds;

  protected ?Post $post = null;
  protected ?\Illuminate\Database\Eloquent\Collection $recentPosts = null;

  public function __construct(int $postId, array $recentPostIds)
  {
    $this->postId = $postId;
    $this->recentPostIds = $recentPostIds;
  }

  protected function loadPosts()
  {
    $this->post = Post::find($this->postId);
    $this->recentPosts = Post::whereIn('id', $this->recentPostIds)->get();
  }

  public function via($notifiable)
  {
    return ['mail'];
  }

  public function toMail($notifiable)
  {
    $this->loadPosts();

    return (new MailMessage)
      ->subject('' . ($this->post ? $this->post->title : ''))
      ->greeting('Hello!')
      ->line('We just published a new blog post that might interest you:')
      ->line('**' . ($this->post ? $this->post->title : '') . '**')
      ->line($this->post ? $this->post->excerpt : '')
      ->action('Read Now', $this->post ? route('blog.post', $this->post->slug) : '#')
      ->view('emails.new-blog-post', [
        'post' => $this->post,
        'recentPosts' => $this->recentPosts,
      ]);
  }
}
