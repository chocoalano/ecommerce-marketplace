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
        Schema::create('ewallet_transactions', function (Blueprint $table) {
            $table->id(); // Kolom id dengan auto increment
            $table->unsignedBigInteger('user_id')->index(); // Kolom user_id dengan index
            $table->enum('transaction_type', ['credit', 'debit']); // Kolom transaction_type
            $table->decimal('amount', 12, 2); // Kolom amount
            $table->decimal('balance', 12, 2); // Kolom balance
            $table->timestamp('transaction_at')->nullable(); // Kolom transaction_at yang nullable
            $table->timestamps(); // Kolom created_at dan updated_at
            // Menambahkan foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ewallet_transactions', function (Blueprint $table) {
            // Menghapus foreign key constraint sebelum menghapus tabel
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('ewallet_transactions');
    }
};
