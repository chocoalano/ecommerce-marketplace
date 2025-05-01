<?php

namespace App\Filament\Seller\Pages;

use App\Models\User;
use App\Support\RajaOngkir;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Http\Responses\Auth\RegistrationResponse;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Registration extends Register
{
    protected RajaOngkir $rajaOngkir;

    public function __construct(RajaOngkir $rajaOngkir)
    {
        parent::__construct();
        $this->rajaOngkir = $rajaOngkir;
    }

    public function form(Form $form): Form
    {
        $provinces = collect($this->rajaOngkir->getProvinces())->pluck('province', 'province_id');
        $cities = collect($this->rajaOngkir->getCities())->pluck('city_name', 'city_name');

        return $form->schema([
            Wizard::make([
                Wizard\Step::make('Account')
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ]),
                Wizard\Step::make('Store')
                    ->schema([
                        TextInput::make('phone_number')->unique('users')->numeric()->tel(),
                        TextInput::make('store_name')->unique('sellers'),
                        FileUpload::make('logo')->directory('logo-store'),
                        Textarea::make('description'),
                    ]),
                Wizard\Step::make('Address')
                    ->schema([
                        Textarea::make('store_address')->required(),
                        Select::make('province')
                            ->searchable()
                            ->options($provinces)
                            ->live()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('city', null)),
                        Select::make('city')
                            ->searchable()
                            ->options(fn (Get $get) => $this->getCitiesByProvince($get('province')))
                            ->required(),
                    ]),
            ])
        ]);
    }

    private function getCitiesByProvince(?string $provinceId): array
    {
        if (!$provinceId) return [];
        return collect($this->rajaOngkir->getCities())
            ->where('province_id', $provinceId)
            ->pluck('city_name', 'city_name')
            ->toArray();
    }

    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone_number' => $data['phone_number'] ?? null,
                'type' => 'seller',
            ]);

            $user->seller()->create([
                'store_name' => $data['store_name'],
                'description' => $data['description'],
                'logo' => $data['logo'] ?? null,
                'store_address' => $data['store_address'],
                'store_status' => 'active',
                'province' => $data['province'],
                'city' => $data['city'],
            ]);

            DB::commit();
            return app(RegistrationResponse::class, ['user' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Debug lebih aman
        }
    }
}
