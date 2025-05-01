<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';   
    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Halaman Website')
                ->description('Halaman ini akan dimuat secara dinamis berdasarkan konten yang telah dibuat.')
                ->schema([
                    TextInput::make('pagename')
                        ->label('Nama Halaman')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true) // Saat blur, akan update slug

                    ->afterStateUpdated(fn (callable $set, $state) => 
                        $set('slug', Str::slug($state))
                    ),

                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255),

                    RichEditor::make('content')
                        ->label('Konten')
                        ->extraInputAttributes(['style' => 'min-height: 50rem; max-height: 50vh; overflow-y: auto;'])
                        ->fileAttachmentsDirectory('pages')
                        ->fileAttachmentsVisibility('public')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(3), // Menggunakan 2 kolom untuk layar besar
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pagename')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
