<?php
namespace App\Filament\Component\Forms;

use App\Models\Product;
use App\Models\Seller;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Mokhosh\FilamentRating\Components\Rating;
class ProductForm
{
    public static function form(): array
    {
        return [
            Select::make('seller_id')
                ->label('Seller')
                ->relationship('seller', 'store_name')
                ->searchable()
                ->default(Seller::where('user_id', auth()->id())->first()?->id ?? null)
                ->visible(fn(): bool => auth()->user()->type === 'admin' ? true : false)
                ->preload()
                ->required(),
            Select::make('category_id')
                ->relationship('category', 'name')
                ->preload()
                ->searchable()
                ->required(),
            TextInput::make('name')
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                    if (($get('slug') ?? '') !== Str::slug($old)) {
                        return;
                    }
                    $set('slug', Str::slug($state));
                })
                ->required()
                ->maxLength(100),
            TextInput::make('slug')
                ->readOnly()
                ->required()
                ->maxLength(255),
            RichEditor::make('description')
                ->toolbarButtons([
                    'blockquote',
                    'bold',
                    'bulletList',
                    'h2',
                    'h3',
                    'italic',
                    'link',
                    'orderedList',
                    'redo',
                    'strike',
                    'underline',
                    'undo',
                ])
                ->required()
                ->columnSpan(2),
            FileUpload::make('primary_image')
                ->image()
                ->directory('product')
                ->columnSpan(2),
            FileUpload::make('image')
                ->image()
                ->multiple()
                ->directory('product')
                ->columnSpan(2),
            TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('Rp.'),
            TextInput::make('stock')
                ->required()
                ->numeric()
                ->default(0),
            Rating::make('rating')
                ->visible(fn(): bool => auth()->user()->type === 'admin' ? true : false)
                ->required(),
            ToggleButtons::make('status')
                ->options(Product::STATUS)
                ->inline()
                ->grouped()
                ->required(),
        ];
    }
}
