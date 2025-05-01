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
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // Kolom id dengan auto increment
            $table->unsignedBigInteger('buyer_id')->index(); // Kolom buyer_id dengan index
            $table->decimal('total_price', 12, 2)->default(0); // Kolom total_price
            $table->unsignedBigInteger('product_id')->index(); // Kolom product_id dengan index
            $table->integer('qty')->default(1); // Kolom qty dengan default 1
            $table->boolean('ispay')->default(false); // Kolom ispay dengan default false
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key constraints
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Menghapus foreign key constraint sebelum menghapus tabel
            $table->dropForeign(['buyer_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('carts');
    }
};
