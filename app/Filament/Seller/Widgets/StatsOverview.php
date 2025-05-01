<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Seller;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '10s';
    protected ?string $heading = 'Analytics';
    protected ?string $description = 'An overview of some analytics.';

    protected function getStats(): array
    {
        // Count total orders and total payments
        $order = Order::count();
        $payment = Payment::count();
        $seller = Seller::count();
        $buyer = User::where('type', 'buyer')->count();

        // Count today's orders and payments
        $order_today = Order::whereDate('created_at', Carbon::today())->count();
        $payment_today = Payment::whereDate('payment_date', Carbon::today())->count();
        $seller_today = Seller::whereDate('created_at', Carbon::today())->count();
        $buyer_today = User::where('type', 'buyer')->whereDate('created_at', Carbon::today())->count();

        return [
            Stat::make('Orders', $order)
                ->description("+$order_today today")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Example chart data
                ->color('info'),

            Stat::make('Payments', $payment)
                ->description("+$payment_today today")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Example chart data
                ->color('success'),

            Stat::make('Seller', $seller)
                ->description("+$seller_today today")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Example chart data
                ->color('warning'),

            Stat::make('Buyer', $buyer)
                ->description("+$buyer_today today")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Example chart data
                ->color('danger'),
        ];
    }
}
