<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('username');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->string('sum')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->foreign('user_id')
                  ->references('id')
                    ->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
