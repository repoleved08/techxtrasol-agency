<?php

namespace App\Filament\Resources\PostResource\Pages;
use App\Models\NewsletterSubscriber;
use App\Notifications\NewBlogPostNotification;

use App\Models\Post;
use Illuminate\Support\Facades\Notification;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;

        if (! $record->is_published || ! $record->published_at || $record->published_at > now()) {
            return;
        }

        $recentPosts = Post::where('is_published', true)
            ->where('id', '!=', $record->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $subscribers = NewsletterSubscriber::where('is_active', true)->get();

        Notification::send($subscribers, new NewBlogPostNotification($record, $recentPosts));
    }
}
