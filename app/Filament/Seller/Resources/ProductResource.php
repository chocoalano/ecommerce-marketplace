<?php

namespace App\Filament\Seller\Resources;

use App\Filament\Seller\Resources\ProductResource\Pages;
use App\Filament\Component\Forms\ProductForm;
use App\Filament\Component\Tables\ProductTable;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Interfaces\ProductPatternInterface;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'carbon-product';

    /**
     * Configure the form schema.
     */
    public static function form(Form $form): Form
    {
        return $form->schema(ProductForm::form());
    }

    /**
     * Configure the table.
     */
    public static function table(Table $table): Table
    {
        $proses = App::make(ProductPatternInterface::class);

        return $table
            ->query(fn() => $proses->filament_table())
            ->columns(ProductTable::table())
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('status')
                    ->options(Product::STATUS)
                    ->label('Status'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('From Date'),
                        DatePicker::make('until')->label('Until Date')->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $product = Product::with('images')->find($data['id']);
                        if ($product) {
                            $data['image'] = $product->images->pluck('image')->toArray();
                        }
                        return $data;
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        if (auth()->user()->type === 'seller') {
                            $data['seller_id'] = auth()->user()?->seller?->id;
                        }
                        return $data;
                    })
                    ->using(function (Model $record, array $data) use ($proses): Model {
                        return $proses->update($record->id, $data);
                    }),
                Tables\Actions\DeleteAction::make()
                    ->using(function ($record) use ($proses) {
                        return $proses->delete($record->id);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * Define the resource pages.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }
}
