<?php

namespace Pardalsalcap\LinterRedirections\Resources;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Pardalsalcap\LinterRedirections\Models\Redirection;
use Pardalsalcap\LinterRedirections\Repositories\RedirectionRepository;
use Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Pages\CreateRedirection;
use Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Pages\EditRedirection;
use Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Pages\ListRedirections;

class RedirectionResource extends Resource
{
    protected static ?string $model = Redirection::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-link';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('url')
                    ->url()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, $old, $state) {
                        if (! empty($state)) {
                            $set('hash', (new RedirectionRepository)->hash($state));
                        }
                    })
                    ->label(__('linter-redirections::redirections.url_column'))
                    ->required(),
                TextInput::make('fix')
                    ->url()
                    ->label(__('linter-redirections::redirections.fix_column'))
                    ->required(),
                TextInput::make('hash')
                    ->label(__('linter-redirections::redirections.hash_column'))
                    ->required()
                    ->readOnly()
                    ->unique('redirections', 'hash', ignoreRecord: true),
                Select::make('http_status')
                    ->label(__('linter-redirections::redirections.http_status_column'))
                    ->options((new RedirectionRepository)->status())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url')
                    ->label(__('linter-redirections::redirections.url_column'))
                    ->url(fn (Redirection $redirection) => $redirection->url)
                    ->openUrlInNewTab()
                    ->searchable(),
                TextColumn::make('fix')
                    ->label(__('linter-redirections::redirections.fix_column'))
                    ->searchable(),
                TextColumn::make('http_status')
                    ->label(__('linter-redirections::redirections.http_status_column'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRedirections::route('/'),
            'create' => CreateRedirection::route('/create'),
            'edit' => EditRedirection::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('linter-redirections::redirections.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('linter-redirections::redirections.model_label_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('linter-redirections::redirections.navigation_group');
    }
}
