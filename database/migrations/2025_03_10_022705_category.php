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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Kolom id dengan auto increment
            $table->string('name'); // Kolom name
            $table->string('slug')->unique(); // Kolom slug yang unik
            $table->string('status')->default('active'); // Kolom status dengan default 'active'
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->softDeletes(); // Kolom deleted_at untuk soft deletes
        });
        Schema::create('category_product', function (Blueprint $table) {
            $table->id(); // Kolom id dengan auto increment
            $table->unsignedBigInteger('category_id')->index(); // Kolom category_id dengan index
            $table->unsignedBigInteger('product_id')->index(); // Kolom product_id dengan index
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Menambahkan constraint unik untuk mencegah duplikasi
            $table->unique(['category_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::table('category_product', function (Blueprint $table) {
            // Menghapus foreign key constraint sebelum menghapus tabel
            $table->dropForeign(['category_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('category_product');
    }
};
