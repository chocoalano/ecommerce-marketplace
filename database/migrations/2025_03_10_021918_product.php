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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->index();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('weight', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->string('status');
            $table->boolean('payment_availability')->default(true);
            $table->string('promotion_set')->nullable();
            $table->string('promotion_get')->nullable();
            $table->string('primary_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
        });

        Schema::dropIfExists('products');
    }
};
