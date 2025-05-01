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
        // Pertama, buat tabel orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id')->index();
            $table->unsignedBigInteger('payment_id')->nullable()->index();
            $table->decimal('total_price', 12, 2);
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Kemudian, buat tabel payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index()->nullable(); // Nullable untuk menghindari masalah saat membuat foreign key
            $table->string('payment_method');
            $table->string('payment_status');
            $table->timestamp('payment_date')->nullable();
            $table->decimal('amount_paid', 12, 2);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        // Terakhir, buat tabel order_items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->integer('qty');
            $table->decimal('item_price', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->decimal('total_weight', 12, 2);
            $table->string('province_store');
            $table->string('city_store');
            $table->unsignedBigInteger('province_id_ro_shipping');
            $table->unsignedBigInteger('city_id_ro_shipping');
            $table->string('courier_ro_shipping');
            $table->string('packet_ro_shipping');
            $table->decimal('cost_ro_shipping', 12, 2);
            $table->text('list_ro_shipping_option')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('order_items');

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });
        Schema::dropIfExists('payments');

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['buyer_id']);
        });
        Schema::dropIfExists('orders');
    }
};