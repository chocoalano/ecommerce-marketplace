<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom id dengan auto increment (primary key)
            $table->string('name'); // Kolom name
            $table->string('email')->unique(); // Kolom email yang unik
            $table->timestamp('email_verified_at')->nullable(); // Kolom untuk verifikasi email
            $table->string('password'); // Kolom password
            $table->string('phone_number', 20)->nullable(); // Kolom phone_number
            $table->enum('type', ['buyer', 'seller', 'admin'])->default('buyer'); // Kolom type
            $table->string('profile_picture')->nullable(); // Kolom profile_picture
            $table->decimal('ewallet_balance', 12, 2)->default(0); // Kolom ewallet_balance
            $table->boolean('activation')->default(1); // Kolom activation
            $table->string('remember_token', 100)->nullable(); // Kolom remember_token
            $table->longText('full_address')->nullable(); // Kolom full_address
            $table->integer('raja_ongkir_city_id')->nullable(); // Kolom raja_ongkir_city_id
            $table->integer('raja_ongkir_province_id')->nullable(); // Kolom raja_ongkir_province_id
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->softDeletes(); // Kolom deleted_at untuk soft deletes
        });
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
