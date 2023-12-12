<?php

namespace Pardalsalcap\LinterRedirections\Resources;

use Filament\Actions\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Pardalsalcap\LinterRedirections\Models\Redirection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Pardalsalcap\LinterRedirections\Repositories\RedirectionRepository;
use Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Pages\CreateRedirection;
use Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Pages\EditRedirection;
use Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Pages\ListRedirections;

class RedirectionResource extends Resource
{
    protected static ?string $model = Redirection::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('url')
                    ->url()
                    ->live(onBlur: true)
                    ->reactive()
                    ->afterStateUpdated(function (Get $get, Set $set, $old, $state) {
                        if (!empty($state)) {
                            $set('hash', (new RedirectionRepository())->hash($state));
                        }
                    })
                    ->label(__("linter-redirections::redirections.url_column"))
                    ->required(),
                Forms\Components\TextInput::make('fix')
                    ->url()
                    ->label(__("linter-redirections::redirections.fix_column"))
                    ->required(),
                Forms\Components\TextInput::make('hash')
                    ->label(__("linter-redirections::redirections.fix_column"))
                    ->required()
                    ->readOnly()
                    ->unique('redirections', 'hash', ignoreRecord: true),
                Forms\Components\Select::make('http_status')
                    ->label(__("linter-redirections::redirections.http_status_column"))
                    ->options((new RedirectionRepository())->status())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('url')
                    ->label(__("linter-redirections::redirections.url_column"))
                    ->url(fn(Redirection $redirection) => $redirection->url)->openUrlInNewTab(true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('fix')
                    ->label(__("linter-redirections::redirections.fix_column"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('http_status')
                    ->label(__("linter-redirections::redirections.http_status_column"))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
