<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()
    {

        Schema::create('sellers', function (Blueprint $table) {
            $table->id(); // Kolom id dengan auto increment
            $table->unsignedBigInteger('user_id')->index(); // Kolom user_id dengan index
            $table->string('store_name', 150)->index(); // Kolom store_name dengan index
            $table->text('description'); // Kolom description
            $table->string('logo', 255)->nullable(); // Kolom logo yang nullable
            $table->text('store_address'); // Kolom store_address
            $table->string('city', 100); // Kolom city
            $table->string('province', 100); // Kolom province
            $table->decimal('rating', 3, 2)->default(0.00); // Kolom rating dengan default 0.00
            $table->enum('store_status', ['active', 'suspended'])->default('active'); // Kolom store_status dengan default 'active'
            $table->enum('store_type', ['electronic', 'grocery', 'fashion', 'property'])->default('electronic'); // Kolom store_type dengan default 'electronic'
            $table->time('store_time_opened')->default('12:39:25'); // Kolom store_time_opened dengan default '12:39:25'
            $table->time('store_time_closed')->default('12:39:25'); // Kolom store_time_closed dengan default '12:39:25'
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()
    {
        Schema::dropIfExists('sellers');
    }
};
