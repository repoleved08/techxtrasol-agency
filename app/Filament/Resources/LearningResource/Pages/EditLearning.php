<?php

namespace App\Filament\Resources\LearningResource\Pages;

use App\Filament\Resources\LearningResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLearning extends EditRecord
{
    protected static string $resource = LearningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
