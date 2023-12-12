<?php

namespace Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Widgets;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Pardalsalcap\LinterRedirections\Models\Redirection;
use Pardalsalcap\LinterRedirections\Resources\RedirectionResource;

class RedirectionsDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    //protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Redirection::latest()->take(10);
    }

    protected function getTableHeading(): string|Htmlable|null
    {
        return __('linter-redirections::redirections.widget_title');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('url')
                ->label(__('linter-redirections::redirections.url_column'))
                ->url(fn (Redirection $redirection) => $redirection->url)
                ->openUrlInNewTab(true)
                ->formatStateUsing(function ($record) {
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
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->url(fn (Redirection $redirection) => RedirectionResource::getUrl().'/'.$redirection->id.'/edit/'),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Tables\Actions\Action::make('View all')
                ->label(__('linter-redirections::redirections.view_all'))
                ->url(RedirectionResource::getUrl()),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
