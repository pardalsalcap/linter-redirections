<?php

namespace Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Widgets;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Pardalsalcap\LinterRedirections\Models\Redirection;
use Pardalsalcap\LinterRedirections\Resources\RedirectionResource;

class RedirectionsDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = null;

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->heading(__('linter-redirections::redirections.widget_title'))
            ->query(Redirection::query()->latest()->limit(10))
            ->columns([
                TextColumn::make('url')
                    ->label(__('linter-redirections::redirections.url_column'))
                    ->url(fn (Redirection $redirection) => $redirection->url)
                    ->openUrlInNewTab()
                    ->formatStateUsing(function (Redirection $record) {
                        return $record->url.'<br />'.$record->fix;
                    })
                    ->html()
                    ->searchable(),
                TextColumn::make('http_status')
                    ->label(__('linter-redirections::redirections.http_status_column'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('linter-redirections::redirections.created_at_column'))
                    ->dateTime(config('linter.date_time_format_tables'))
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn (Redirection $redirection) => RedirectionResource::getUrl('edit', ['record' => $redirection])),
            ])
            ->headerActions([
                Action::make('viewAll')
                    ->label(__('linter-redirections::redirections.view_all'))
                    ->url(RedirectionResource::getUrl()),
            ])
            ->paginated(false);
    }
}
