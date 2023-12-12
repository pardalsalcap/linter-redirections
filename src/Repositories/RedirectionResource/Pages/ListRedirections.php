<?php

namespace Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Pages;

use App\Filament\Resources\RedirectionResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Pardalsalcap\LinterRedirections\Models\Redirection;

class ListRedirections extends ListRecords
{
    protected static string $resource = RedirectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('deletePending')
                ->action(function () {
                    Redirection::whereNull('fix')->delete();
                })
                ->badge(fn () => Redirection::whereNull('fix')->count())
                ->label(__('linter-redirections::redirections.delete_pending'))
                ->visible(fn () => Redirection::whereNull('fix')->count() > 0)
                ->requiresConfirmation(),
            Actions\CreateAction::make(),
        ];
    }
}
