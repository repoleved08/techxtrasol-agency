<?php

namespace App\Filament\Resources\LearningCategoryResource\Pages;

use App\Filament\Resources\LearningCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLearningCategory extends EditRecord
{
    protected static string $resource = LearningCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
